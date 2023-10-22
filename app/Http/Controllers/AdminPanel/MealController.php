<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\Meal\StoreMealRequest;
use App\Models\Category;
use App\Models\Meal;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MealController extends Controller
{

    public function __construct()
    {
        $this->middleware('superadmin')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $meals = Meal::all();
        return view('meals.index', [
            'meals' => $meals
        ]);
    }

    public function generateImg(Request $request)
    {
        # code
        $validator = \Validator::make($request->all(), [
            'prompt' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'fail_msg' => 'Unesite prompt za generisanje'
            ]);
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer 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'
        ])
            ->post('https://api.openai.com/v1/images/generations', [
                'prompt' => $request->prompt,
                'n' => 1,
                'size' => '256x256',
                'response_format' => 'b64_json'
            ]);

        $image = explode('base64,', $response->json('data')[0]['b64_json']);
        $image = end($image);
        $image = str_replace(' ', '+', $image);
        $file = "meals/" . uniqid() . '.png';

        Storage::disk('public')->put($file, base64_decode($image));

        return response()->json([
            'url' => asset('/storage/' . $file)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        $types = Type::all();
        return view('meals.create', [
            'categories' => $categories,
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMealRequest $request)
    {
        //
        $input = $request->validated();

        $meal = new Meal(\Arr::only($input, ['name', 'price', 'category_id', 'description', 'photoPath']));
        $meal->save();

        $meal->types()->sync($input['types']);
        return redirect()->route('meals.index')->with('success', 'New Meal successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        //
        $categories = Category::all();
        $types = Type::all();

        $orders = $meal->orders()->withPivot('rating')->wherePivotNotNull('rating')->get();

        return view('meals.show', [
            'meal' => $meal,
            'categories' => $categories,
            'types' => $types,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        //
        return redirect(route('meals.show', $meal) . '#settings');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMealRequest $request, Meal $meal)
    {
        //
        $input = $request->validated();
        $meal->update(\Arr::only($input, ['name', 'price', 'category_id', 'description']));

        $meal->types()->sync($input['types']);
        return redirect()->route('meals.index')->with('success', 'Meal successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
