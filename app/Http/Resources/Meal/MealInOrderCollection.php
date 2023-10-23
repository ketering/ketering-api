<?php

namespace App\Http\Resources\Meal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealInOrderCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => new CategoryCollection($this->category),
            'types' => TypeCollection::collection($this->types),
            'name' => $this->name,
            'photoPath' => $this->photoPath,
            'price' => $this->price,
            'rating' => $this->avg_rating,
            'amount' => $this->pivot->amount
        ];
    }
}
