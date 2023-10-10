<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Get status of an order
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        # code
        return $this->belongsTo(Status::class);
    }

    /**
     * Get all meals from an order
     *
     * @return BelongsToMany
     */
    public function meals(): BelongsToMany
    {
        # code
        return $this->belongsToMany(Meal::class);
    }
}
