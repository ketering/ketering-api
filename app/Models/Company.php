<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * Get all users of some company
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        # code
        return $this->hasMany(User::class);
    }
}
