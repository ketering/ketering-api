<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Meal\MealCollection;
use App\Http\Resources\Meal\MealResource;
use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MealController extends BaseController
{
    //

    /**
     * Get all meals or search them
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        # code
        $validator = \Validator::make($request->all(), [
            'search' => ['']
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $meals = Meal::where('name', 'LIKE', '%' . $request->search . '%')->get();
        $response = MealCollection::collection($meals);

        return $this->sendResponse($response, 'Meals fetched successfully');
    }

    public function show(Meal $meal)
    {
        # code
        $response = new MealResource($meal);

        return $this->sendResponse($response, 'Meal fetched successfully');
    }
}
