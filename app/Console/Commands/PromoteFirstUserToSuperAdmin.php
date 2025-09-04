<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class PromoteFirstUserToSuperAdmin extends Command
{
    protected $signature = 'user:promote-first-to-superadmin';
    protected $description = 'Promote the first user in database to Super Admin';

    public function handle()
    {
        $user = User::orderBy('id')->first();

        if (!$user) {
            $this->error('No user found in database!');
            return 1;
        }

        // Créer le rôle super_admin s'il n'existe pas
        $role = Role::firstOrCreate(
            ['name' => 'super_admin'],
            ['grade' => 0, 'guard_name' => 'web']
        );

        // Assigner le rôle à l'utilisateur
        $user->syncRoles(['super_admin']);

        $this->info("User {$user->email} has been promoted to Super Admin!");
        return 0;
    }
}
