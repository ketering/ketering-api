<?php

namespace App\Http\Resources\Meal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealByCatCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category' => new CategoryCollection($this),
            'meals' => MealCollection::collection($this->meals)
        ];
    }
}
