<?php

namespace Database\Seeders;
use App\Models\Period;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $periods = [
            ['name'=>'1st Period','start_time'=>'08:00','end_time'=>'09:00'],
            ['name'=>'2nd Period','start_time'=>'09:00','end_time'=>'10:00'],
            ['name'=>'3rd Period','start_time'=>'10:00','end_time'=>'11:00'],
            ['name'=>'4th Period','start_time'=>'11:00','end_time'=>'12:00'],
            ['name'=>'5th Period','start_time'=>'12:00','end_time'=>'13:00'],
            ['name'=>'6th Period','start_time'=>'13:00','end_time'=>'14:00'],
        ];

        foreach($periods as $p) {
            Period::create($p);
        }
    }
}
