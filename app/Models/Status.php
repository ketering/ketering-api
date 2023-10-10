<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    /**
     * Get all orders of some order-status
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        # code
        return $this->hasMany(Order::class);
    }
}
