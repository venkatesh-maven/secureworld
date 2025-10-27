<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RestoreUsersAndRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $roles = [
            ['role_name' => 'admin', 'description' => 'Administrator'],
            ['role_name' => 'manager', 'description' => 'Manager'],
            ['role_name' => 'technician', 'description' => 'Technician'],
            ['role_name' => 'technician2', 'description' => 'Technician2'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['role_name' => $role['role_name']], $role);
        }

        // Create Admin
        $adminRole = Role::where('role_name', 'admin')->first();
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole->id
            ]
        );
    }
}

