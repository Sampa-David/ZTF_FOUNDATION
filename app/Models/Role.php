<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table='roles';
    protected $fillable = [
        'name',
        'display_name',
        'grade',
        
    ];

    public function users(){
        return $this->belongsToMany(User::class,'role_users');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_roles');
    }
}
