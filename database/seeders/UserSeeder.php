<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Teacher User',
                'email' => 'teacher@test.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Student User',
                'email' => 'student@test.com',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
