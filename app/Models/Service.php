<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'department_id',
        'department_code',
        'location',
        'phone',
        'email',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function users(){
        return $this->hasMany(User::class);
    } 

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function manager() {
        return $this->users()->whereHas('roles', function($query) {
            $query->where('name', 'manager');
        })->first();
    }
}
