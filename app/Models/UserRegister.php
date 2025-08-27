<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class UserRegister extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * Table associée au modèle.
     * @var string
     */
    protected $table = 'users';

    /**
     * Les attributs pouvant être assignés en masse.
     * @var array
     */
    protected $fillable = [
        'matricule',
        'email',
        'password',
    ];

    /**
     * Les attributs cachés pour la sérialisation.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     public function Departement(){
        return $this->belongsTo(Departement::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function headDepartment(){
        return $this->hasMany(Departement::class,'head_id');
    }

    public function comite(){
        return $this->belongsTo(Committee::class,'department_id');
    }
}
