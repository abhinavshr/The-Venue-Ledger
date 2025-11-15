<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FutsalVenueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('futsal_venues')->insert([
            [
                'name' => 'Downtown Futsal Arena',
                'address' => 'New Baneshwor, Kathmandu',
                'contact_email' => 'info@downtownfutsal.com',
                'contact_phone' => 9876271211,
                'logo_url' => 'https://example.com/images/futsal-logo.png',
                'verification' => true, 
                'user_id' => 1, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}