<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartementSkill extends Model
{
    protected $fillable=[
        'name',
        'description',
        'dept_id'
    ];

    public function Departement(){
        return $this->belongsTo(Departement::class);
    }


}
