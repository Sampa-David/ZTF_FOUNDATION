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

    public function departments(){
        return $this->hasMany(Departement::class);
    }
}
