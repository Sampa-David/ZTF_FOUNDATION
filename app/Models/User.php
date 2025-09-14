<?php
namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

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
        'name',
        'matricule',
        'email',
        'password',
        'department_id',
        'committee_id',
        'service_id',
        'created_at',
        'last_login_at',
        'last_activity_at',
        'last_login_ip'
    ];

     protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'info_updated_at' => 'datetime',
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
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function headDepartment(){
        return $this->hasMany(Department::class,'head_id');
    }

    public function comite(){
        return $this->belongsTo(Committee::class,'department_id');
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique avec un grade optionnel
     * 
     * @param string $roleName Le nom du rôle à vérifier
     * @param int|null $grade Le grade à vérifier (optionnel)
     * @return bool
     */
    /**
     * Relation avec les rôles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_users','user_id','permission_id');
    }

    public function roleCodeFromMatricule():?string{
        if(!$this->matricule) return null;

        if(str_contains($this->matricule, '-')){
            $segment=explode('-',$this->matricule);
            return end($segment);
        }

        preg_match('/[A-Z]+/', $this->matricule, $matches);

         if(!empty($matches)){
            $letters=$matches[0];
            $roleCode=substr($letters,-1);
            return $roleCode;
         }

        return null;
    }

    public function
    
    /**
     * Vérifie si l'utilisateur est super administrateur
     * (le plus haut niveau hiérarchique)
     * 
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Vérifie si l'utilisateur est membre du comité de nehemie
     * 
     * @return bool
     */
    public function isAdmin1(): bool
    {
        return $this->hasRoleWithGrade('admin', 1);
    }

    /**
     * Vérifie si l'utilisateur est chef de département
     * 
     * @return bool
     */
    public function isAdmin2(): bool
    {
        // Vérifie si le matricule commence par CM-HQ-CD
        $hasHeadDeptMatricule = str_starts_with($this->matricule, 'CM-HQ-CD');
        
        // Vérifie soit le rôle/grade, soit le format du matricule
        return $this->hasRoleWithGrade('admin', 2) || $hasHeadDeptMatricule;
    }

    /**
     * Vérifie si l'utilisateur est un membre du staff (incluant les chefs de service)
     * 
     * @return bool
     */
    public function isStaff(): bool
    {
        // Le staff inclut les membres réguliers et les chefs de service
        return $this->hasRoleWithGrade('staff', 3) || $this->hasRoleWithGrade('chef_service', 3);
    }

    /**
     * Vérifie si l'utilisateur a des droits d'administration
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        // Soit super admin, soit membre du comité
        return $this->isSuperAdmin() || $this->isAdmin1();
    }
}
