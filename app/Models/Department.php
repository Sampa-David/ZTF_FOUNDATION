<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
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

    public function users(){
        return $this->hasMany(User::class,'department_id');
    }

    public function headDepartment(){
        return $this->belongsTo(User::class, 'head_id', 'id');
    }

    public function skills(){
        return $this->hasMany(DepartementSkill::class, 'department_id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'department_id');
    }
    
}
