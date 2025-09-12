<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'matricule' => $data['matricule']
        ]);

        // Si le matricule commence par CM-HQ-CD
        if (str_starts_with(strtoupper($user->matricule), 'CM-HQ-CD')) {
            $admin2Role = Role::where('name', 'admin-2')->first();
            
            if ($admin2Role) {
                $user->assignRole($admin2Role);
                Log::info('Role Admin2 assigned to user with matricule: ' . $user->matricule);
            } else {
                Log::error('Admin2 role not found in database');
            }
        }

        return $user;
    }
}