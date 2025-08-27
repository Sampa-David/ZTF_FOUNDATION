<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $table='committees';
    protected $fillable=[
        'name',
        'description'
    ];

    public function Departement(){
        return $ths->hasMany(Department::class);
    }
}
