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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function Department_Skills(){
        return $this->hasMany(DepartmentSkill::class);
    }

    
}
