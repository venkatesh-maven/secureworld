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
        // Roles
        $roles = [
            ['role_name' => 'admin', 'description' => 'admin'],
            ['role_name' => 'manager', 'description' => 'manager'],
            ['role_name' => 'technician', 'description' => 'technician'],
            ['role_name' => 'technician2', 'description' => 'technician2'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Users
        $users = [
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'role_name' => 'admin'],
            ['name' => 'abc', 'email' => 'xyza@gmail.com', 'role_name' => 'technician'],
            ['name' => 'bunny', 'email' => 'navya@gmail.com', 'role_name' => 'technician'],
            ['name' => 'navya', 'email' => 'abc@gmail.com', 'role_name' => 'technician2'],
        ];

        foreach ($users as $user) {
            $role = Role::where('role_name', $user['role_name'])->first();

            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'), // default password
                'role_id' => $role->id,
            ]);
        }
    }
}

