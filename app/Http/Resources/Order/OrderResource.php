<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Meal\MealCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status->name,
            'rating' => $this->rating,
            'totalPrice' => $this->totalPrice,
            'forDate' => $this->forDate,
            'description' => $this->description,
            'meals' => MealCollection::collection($this->meals)
        ];
    }
}
