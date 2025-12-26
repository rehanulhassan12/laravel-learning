<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;

class ScreenSeeder extends Seeder
{
    public function run()
    {
        $user = Screen::create([
            'name' => 'Users',
            'route_name' => 'users',
        ]);

        $schoolGroups = Screen::create([
            'name' => 'School Groups',
            'route_name' => 'school_groups',
        ]);

        $schools = Screen::create([
            'name' => 'Schools',
            'route_name' => 'schools',
            'parent_id' => $schoolGroups->id,
        ]);

        $classes = Screen::create([
            'name' => 'Classes',
            'route_name' => 'classes',
            'parent_id' => $schools->id,
        ]);

        Screen::create([
            'name' => 'Students',
            'route_name' => 'students',
            'parent_id' => $classes->id,
        ]);
    }
}
