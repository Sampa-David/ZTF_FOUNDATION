<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable=[
        'name',
        'description',
        'head_id'
    ];


    protected static function booted (){
        static::deleting(function ($department){
            $department->users()->delete();
        });
    }

    public function uers(){
        return $this->hasMany(UserRegister::class,'department_id');
    }

    public function Department_Skills(){
        return $this->hasMany(DepartmentSkill::class);
    }

    
}
