<?php

namespace App\Http\Resources\Meal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photoPath' => $this->photoPath,
            'price' => $this->price,
            'rating' => $this->avg_rating,
            'category' => new CategoryCollection($this->category),
            'types' => TypeCollection::collection($this->types),
            'description' => $this->description
        ];
    }
}
