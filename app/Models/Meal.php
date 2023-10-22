<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'description',
        'avg_rating'
    ];

    /**
     * Get category of meal
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        # code
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all types of meal
     *
     * @return BelongsToMany
     */
    public function types(): BelongsToMany
    {
        # code
        return $this->belongsToMany(Type::class);
    }

    public function orders(): BelongsToMany
    {
        # code
        return $this->belongsToMany(Order::class);
    }
}
