<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des rôles
        $roles = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'display_name' => 'Super Administrateur',
                'description' => 'Accès complet à toutes les fonctionnalités',
                'grade' => 0
            ],
            [
                'name' => 'admin-1',
                'guard_name' => 'web',
                'display_name' => 'Membre du Comité',
                'description' => 'Membre du comité de nehemie avec accès étendu',
                'grade' => 1
            ],
            [
                'name' => 'admin-2',
                'guard_name' => 'web',
                'display_name' => 'Chef de Département',
                'description' => 'Gestion d\'un département spécifique',
                'grade' => 2
            ],
            [
                'name' => 'staff',
                'guard_name' => 'web',
                'display_name' => 'Staff',
                'description' => 'Membre du personnel standard',
                'grade' => 3
            ],
            [
                'name' => 'chef_service',
                'guard_name' => 'web',
                'display_name' => 'Chef de Service',
                'description' => 'Gestion d\'un service spécifique',
                'grade' => 3
            ]
        ];

        // Création des permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'manage roles',
            'manage departments',
            'manage services',
            'view reports'
        ];

        // Création des permissions dans la base de données
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
                'display_name' => ucfirst(str_replace('_', ' ', $permission)),
                'description' => 'Permission de ' . $permission
            ]);
        }

        // Création des rôles et attribution des permissions
        foreach ($roles as $role) {
            $roleModel = Role::create([
                'name' => $role['name'],
                'guard_name' => $role['guard_name'],
                'display_name' => $role['display_name'],
                'description' => $role['description'],
                'grade' => $role['grade']
            ]);

            // Attribution des permissions selon le rôle
            switch ($role['name']) {
                case 'super_admin':
                    $roleModel->givePermissionTo(Permission::all());
                    break;
                    
                case 'admin-1':
                    $roleModel->givePermissionTo([
                        'view dashboard',
                        'manage users',
                        'manage departments',
                        'manage services',
                        'view reports'
                    ]);
                    break;

                case 'admin-2':
                    $roleModel->givePermissionTo([
                        'view dashboard',
                        'manage users',
                        'manage services',
                        'view reports'
                    ]);
                    break;

                case 'chef_service':
                    $roleModel->givePermissionTo([
                        'view dashboard',
                        'manage users',
                        'view reports'
                    ]);
                    break;

                case 'staff':
                    $roleModel->givePermissionTo([
                        'view dashboard'
                    ]);
                    break;
            }
        }
    }
}
