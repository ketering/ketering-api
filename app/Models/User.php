<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role_id',
        'surname',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Get show my profile url
     *
     * @return string
     */
    public static function adminlte_profile_url(): string
    {
        # code
        return '#';
    }

    public function adminlte_image(): string
    {
        # code
        return $this->photoPath ?: asset('img/user.svg');
    }


    /**
     * Get Role of user
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        # code
        return $this->belongsTo(Role::class);
    }

    /**
     * Get Company of user
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        # code
        return $this->belongsTo(Company::class);
    }
}
