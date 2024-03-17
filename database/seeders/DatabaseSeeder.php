<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'doctor', 'patient'];
        Role::insert(array_map(fn ($role) => ['name' => $role], $roles));

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'admin')->first()->id
        ]);
    }
}
