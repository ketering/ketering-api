<?php

namespace App\Http\Controllers\Api;

use App\Models\Meal;
use App\Models\Order;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends BaseController
{
    //
    public function store(Request $request)
    {
        # code
        $validator = \Validator::make($request->all(), [
            'meals' => ['required', 'array'],
            'meals.*' => ['array'],
            'meals.*.*' => ['integer'],
            'inAdvance' => ['nullable', 'int'],
            'description' => ['nullable']
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $input = $validator->validated();

        $order = new Order([
            'forDate' => today(),
            'description' => $input['description']
        ]);

        $order->status()->associate(Status::find(1));
        auth()->user()->orders()->save($order);

        $total = 0;
        array_map(function ($data) use (&$total, $order) {
            $meal = Meal::findOrFail($data[0]);
            $total += $meal->price * $data[1];
            $order->meals()->attach($meal, [
                'amount' => $data[1]
            ]);
        }, $input['meals']);

        $order->update(['totalPrice' => $total]);

        if ($inAdvance = $input['inAdvance']) {
            for ($i = 0; $i < $inAdvance; $i++) {
                $new = $order->replicate();
                $new->forDate = Carbon::parse($order->forDate)->addDays($i+1);
                $new->save();
                $order->meals()->withPivot('amount')->get()->map(function ($meal) use ($new) {
                    $new->meals()->attach($meal, [
                        'amount' => $meal->pivot->amount
                    ]);
                });
            }
        }

        return $this->sendResponse('', 'Order created successfully');
    }
}
