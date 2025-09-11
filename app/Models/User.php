<?php
namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

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
        return $this->belongsTo(Departement::class,'departmen_users','user_id','department_id');
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

    /**
     * Get all roles associated with the user
     */
    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles', 'model_id', 'role_id');
    }

    /**
     * Get all direct permissions associated with the user
     */
    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions', 'model_id', 'permission_id');
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique avec un grade optionnel
     * 
     * @param string $roleName Le nom du rôle à vérifier
     * @param int|null $grade Le grade à vérifier (optionnel)
     * @return bool
     */
    public function hasRole(string $roleName, int $grade = null): bool
    {
        return $this->roles->contains(function ($role) use ($roleName, $grade) {
            // Si un grade est spécifié, vérifie le nom du rôle et le grade
            if ($grade !== null) {
                return $role->name === $roleName && $role->grade === $grade;
            }
            // Sinon, vérifie uniquement le nom du rôle
            return $role->name === $roleName;
        });
    }

    /**
     * Vérifie si l'utilisateur a une permission spécifique
     * 
     * @param string $permissionName Le nom de la permission à vérifier
     * @return bool
     */
    public function hasPermission(string $permissionName): bool
    {
        // Vérifie dans tous les rôles de l'utilisateur
        return $this->roles->contains(function ($role) use ($permissionName) {
            return $role->permissions->contains('name', $permissionName);
        });
    }

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
        return $this->hasRole('admin', 1);
    }

    /**
     * Vérifie si l'utilisateur est chef de département
     * 
     * @return bool
     */
    public function isAdmin2(): bool
    {
        return $this->hasRole('admin', 2);
    }

    /**
     * Vérifie si l'utilisateur est un membre du staff (incluant les chefs de service)
     * 
     * @return bool
     */
    public function isStaff(): bool
    {
        // Le staff inclut les membres réguliers et les chefs de service
        return $this->hasRole('staff', 3) || $this->hasRole('chef_service', 3);
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

    /**
     * Obtient toutes les permissions de l'utilisateur via ses rôles
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAllPermissions()
    {
        return $this->roles->flatMap->permissions->unique('id');
    }
}
