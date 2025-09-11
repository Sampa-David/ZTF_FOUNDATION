<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Guard;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'guard_name'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_has_permissions',
            'permission_id',
            'role_id'
        );
    }

    /**
     * Find a permission by its name.
     *
     * @param string $name
     * @param string|null $guardName
     * @return \Spatie\Permission\Contracts\Permission
     */
    public static function findByName(string $name, ?string $guardName = null): \Spatie\Permission\Contracts\Permission
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        return static::where('name', $name)->where('guard_name', $guardName)->firstOrFail();
    }
}
