<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departments';
    
    protected $fillable = [
        'name',
        'description',
        'head_id'
    ];


    protected static function booted (){
        static::deleting(function ($department){
            $department->users()->delete();
        });
    }

    public function users(){
        return $this->hasMany(User::class,'department_id');
    }

    public function headDepartment(){
        return $this->belongsTo(User::class,'head_id', 'user_id');
    }

    public function Department_Skills(){
        return $this->hasMany(DepartmentSkill::class,'department_id');
    }

    
}
