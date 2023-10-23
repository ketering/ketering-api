<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Meal\CategoryCollection;
use App\Http\Resources\Meal\MealByCatCollection;
use App\Http\Resources\Meal\MealCollection;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends BaseController
{
    //

    /**
     * Get all meal categories
     * @return JsonResponse
     */
    public function index()
    {
        # code
        $categories = Category::all();
        $response = CategoryCollection::collection($categories);

        return $this->sendResponse($response, 'Categories fetched successfully');
    }

    public function show(Category $category)
    {
        # code
        $response = new MealByCatCollection($category);

        return $this->sendResponse($response, 'Meals fetched successfully');
    }
}
