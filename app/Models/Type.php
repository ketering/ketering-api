<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    use HasFactory;

    /**
     * Get all meals of some type
     *
     * @return BelongsToMany
     */
    public function meals(): BelongsToMany
    {
        # code
        return $this->belongsToMany(Meal::class);
    }
}
