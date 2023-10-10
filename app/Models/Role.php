<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    const GUEST = 4;

    const EMPLOYEE = 3;

    const ADMIN = 2;

    const SUPERADMIN = 1;

    /**
     * Get all users of some role
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        # code
        return $this->hasMany(User::class);
    }

    /**
     * Get guest role
     *
     * @return mixed
     */
    public static function guest(): mixed
    {
        # code
        $role = Role::findOrNew(Role::GUEST);
        if (!$role->id) {
            $role->id = Role::GUEST;
            $role->name = 'Guest';
            $role->save();
        }
        return $role;
    }

    /**
     * Get employee role
     *
     * @return mixed
     */
    public static function employee(): mixed
    {
        # code
        $role = Role::findOrNew(Role::EMPLOYEE);
        if (!$role->id) {
            $role->id = Role::EMPLOYEE;
            $role->name = 'Employee';
            $role->save();
        }
        return $role;
    }

    /**
     * Get superadmin role
     *
     * @return mixed
     */
    public static function admin(): mixed
    {
        # code
        $role = Role::findOrNew(Role::ADMIN);
        if (!$role->id) {
            $role->id = Role::ADMIN;
            $role->name = 'Admin';
            $role->save();
        }
        return $role;
    }

    /**
     * Get superadmin role
     *
     * @return mixed
     */
    public static function superadmin(): mixed
    {
        # code
        $role = Role::findOrNew(Role::SUPERADMIN);
        if (!$role->id) {
            $role->id = Role::SUPERADMIN;
            $role->name = 'SuperAdmin';
            $role->save();
        }
        return $role;
    }

    /**
     * Reset roles table to only predefined values
     *
     * @return void
     */
    public static function resetRoles(): void
    {
        # code
        try {
            DB::table('roles')->delete();
        } catch (\Exception $e) {
        }
        Role::guest();
        Role::employee();
        Role::admin();
        Role::superadmin();
    }
}
