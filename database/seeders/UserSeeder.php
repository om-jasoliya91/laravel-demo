<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Check if admin already exists

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),  // choose secure password
            'role' => 0,  // admin
            'age' => 30,
            'city' => 'Admin City',
            'address' => 'Admin Address',
            'profile_pic' => null,  // optional
        ]);
    }
}
