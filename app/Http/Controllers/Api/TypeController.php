<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\Meal\MealCollection;
use App\Http\Resources\Meal\TypeCollection;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends BaseController
{
    //

    /**
     * Get all meal types
     * @return JsonResponse
     */
    public function index()
    {
        # code
        $types = Type::all();
        $response = TypeCollection::collection($types);

        return $this->sendResponse($response, 'Meal types fetched successfully');
    }

    /**
     * Get filtered meals by types
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        # code
        $validator = \Validator::make($request->all(), [
            'ids' => ['required', 'array'],
            'ids*' => ['required', 'int']
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $types = Type::findMany($request->ids);
        $meals = $types->map(function ($type) {
            return $type->meals;
        })->flatten()->unique('id');

        $response = MealCollection::collection($meals);

        return $this->sendResponse($response, 'Meal fetched successfully');
    }
}
