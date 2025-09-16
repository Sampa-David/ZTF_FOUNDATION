<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use App\Models\DepartementSkill;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'head_id',
        'head_assigned_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'head_assigned_at' => 'datetime'
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

    public function head(){
        return $this->belongsTo(User::class, 'head_id', 'id');
    }

    public function skills(){
        return $this->hasMany(DepartementSkill::class, 'department_id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'department_id');
    }
    
}
