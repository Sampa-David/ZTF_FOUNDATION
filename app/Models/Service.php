<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable=[
        'name',
        'description',
        'department_id'
    ];

    public function user(){
        return $this->hasMany(User::class);
    } 

    public function Department(){
        return $this->belongsTo(Department::class);
    }
}
