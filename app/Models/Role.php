<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Guard;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'display_name',
        'grade',
        'description',
        'guard_name'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            config('permission.table_names.model_has_roles'),
            'role_id',
            'model_id'
        )->where('model_type', User::class);
    }

    /**
     * Find a role by its name.
     *
     * @param string $name
     * @param string|null $guardName
     * @return \Spatie\Permission\Contracts\Role
     */
    public static function findByName(string $name, ?string $guardName = null): \Spatie\Permission\Contracts\Role
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        return static::where('name', $name)->where('guard_name', $guardName)->firstOrFail();
    }
}
