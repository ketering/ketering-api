<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends BaseController
{
    //
    public function index()
    {
        # code
        $orders = auth()->user()->orders()->orderBy('forDate', 'desc')->get();
        $response = OrderCollection::collection($orders);

        return $this->sendResponse($response, 'Orders fetched successfully');
    }

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
                $new->forDate = Carbon::parse($order->forDate)->addDays($i + 1);
                $new->save();
                $order->meals()->withPivot('amount')->get()->map(function ($meal) use ($new) {
                    $new->meals()->attach($meal, [
                        'amount' => $meal->pivot->amount
                    ]);
                });
            }
        }

        return $this->sendResponse('', 'Narudžbina uspješno kreiran');
    }

    public function show(Order $order)
    {
        # code
        $response = new OrderResource($order);

        return $this->sendResponse($response, 'Order fetched successfully');
    }

    public function rate(Request $request, Order $order)
    {
        # code
        $validator = \Validator::make($request->all(), [
            'order_rating' => ['nullable', 'integer'],
            'meals_rating' => ['nullable', 'array'],
            'meals_rating.*' => ['nullable', 'array'],
            'meals_rating.*.*' => ['nullable', 'integer']
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $input = $validator->validated();
        $order->update(['rating' => $input['order_rating']]);

        if ($ratings = $input['meals_rating']) {
            foreach ($ratings as $r) {
                $order->meals()->withPivot('rating')->where('meal_id', $r[0])->update(['rating' => $r[1]]);
                $meal = Meal::find($r[0]);
                $meal->avg_rating = is_null($meal->avg_rating) ? $r[1] : ($meal->avg_rating + $r[1]) / 2;
                $meal->save();
            }
        }
    }
}
