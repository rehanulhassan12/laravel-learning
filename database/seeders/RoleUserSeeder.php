<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role_user')->insert([
            ['user_id' => 2, 'role_id' => 1], // Admin User → admin
            ['user_id' => 3, 'role_id' => 2], // Teacher User → teacher
            ['user_id' => 4, 'role_id' => 4], // Student User → student
        ]);
    }
}
