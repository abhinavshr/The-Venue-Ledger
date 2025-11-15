<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('court_schedules')->insert([
            [
                'futsal_venue_id' => 1, 
                'court_id' => 1,        
                'start_time' => Carbon::createFromTime(8, 0, 0)->format('H:i:s'),
                'end_time'   => Carbon::createFromTime(9, 0, 0)->format('H:i:s'),
                'max_slots'  => 6,
                'recurring_days' => 'Mon,Wed,Fri',
                'created_at' => now(),
                'updated_at' => now(),
            ]]);
    }
}