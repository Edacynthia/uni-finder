<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        $roles = ['admin', 'marketer', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // change later
            ]
        );
        $admin->assignRole('admin');

        // Marketer
        $marketer = User::firstOrCreate(
            ['email' => 'marketer@example.com'],
            [
                'name' => 'John Marketer',
                'password' => bcrypt('password'),
            ]
        );
        $marketer->assignRole('marketer');

        // Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Jane User',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole('user');


        foreach (User::all() as $key => $user) {
            if ($user->hasRole('marketer'))
                $user->marketerProfile()->create();
        }
    }
}
