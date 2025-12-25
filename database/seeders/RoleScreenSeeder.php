<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleScreenSeeder extends Seeder
{
    public function run(): void
    {
        // Clear old data
        DB::table('role_screen')->truncate();

        // Admin -> all screens
        DB::table('role_screen')->insert([
            ['role_id' => 1, 'screen_id' => 3],
            ['role_id' => 1, 'screen_id' => 4],
            ['role_id' => 1, 'screen_id' => 5],
            ['role_id' => 1, 'screen_id' => 6],
            ['role_id' => 1, 'screen_id' => 7],
        ]);

        // Teacher -> Schools + Classes
        DB::table('role_screen')->insert([
            ['role_id' => 2, 'screen_id' => 4],
            ['role_id' => 2, 'screen_id' => 6],
        ]);

        // Staff -> Schools + School Groups
        DB::table('role_screen')->insert([
            ['role_id' => 3, 'screen_id' => 4],
            ['role_id' => 3, 'screen_id' => 5],
        ]);

        // Student -> none for now (can be added later)
    }
}
