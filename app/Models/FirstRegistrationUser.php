<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstRegistrationUser extends Model
{
    protected $table = 'first_registration_users';
    protected $fillable = [
        'first_name','first_email','first_password'
    ];
    // Pour une autre base de donnee:
    //protected $connection = 'first_registration_mysql';
}
