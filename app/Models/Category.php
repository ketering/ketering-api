<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description'
    ];

    /**
     * Get all meals of some category
     *
     * @return HasMany
     */
    public function meals(): HasMany
    {
        # code
        return $this->hasMany(Meal::class);
    }
}
