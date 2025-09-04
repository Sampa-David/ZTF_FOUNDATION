<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    protected $table='permissions';
    protected $fillable = [
        'name',
        'description'
    ];

    public function role(){
        return $this->belongsToMany(Role::class,'permission_roles');
    }
}
