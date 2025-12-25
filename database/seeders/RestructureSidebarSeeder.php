<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;

class RestructureSidebarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Find the "Schools" (or "School") screen
        $schoolScreen = Screen::where('name', 'like', '%School%')
            ->where('name', 'not like', '%Group%') // Exclude School Groups if possible
            ->first();

        // 2. Find the "Classes" (or "Class") screen
        $classScreen = Screen::where('name', 'like', '%Class%')->first();

        // 3. Find the "Students" (or "Student") screen
        $studentScreen = Screen::where('name', 'like', '%Student%')->first();

        if ($schoolScreen && $classScreen) {
            $classScreen->parent_id = $schoolScreen->id;
            $classScreen->save();
            $this->command->info("Nested '{$classScreen->name}' under '{$schoolScreen->name}'");
        } else {
            $this->command->error("Could not find School or Class screens");
        }

        if ($classScreen && $studentScreen) {
            $studentScreen->parent_id = $classScreen->id;
            $studentScreen->save();
            $this->command->info("Nested '{$studentScreen->name}' under '{$classScreen->name}'");
        } else {
             $this->command->error("Could not find Class or Student screens");
        }
    }
}
