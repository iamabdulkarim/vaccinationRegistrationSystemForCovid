<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $existingCenters = DB::table('vaccine_centers')->count();

        if ($existingCenters == 0) {
            // Prepopulate with vaccine centers in Bangladesh if none exist
            DB::table('vaccine_centers')->insert([
                ['center_name' => 'Dhaka Medical College Hospital', 'location' => 'Dhaka', 'daily_limit' => 200],
                ['center_name' => 'Bangabandhu Sheikh Mujib Medical University', 'location' => 'Dhaka', 'daily_limit' => 150],
                ['center_name' => 'Chittagong Medical College', 'location' => 'Chittagong', 'daily_limit' => 180],
                ['center_name' => 'Rajshahi Medical College', 'location' => 'Rajshahi', 'daily_limit' => 130],
                ['center_name' => 'Khulna Medical College', 'location' => 'Khulna', 'daily_limit' => 140],
                ['center_name' => 'Sylhet MAG Osmani Medical College', 'location' => 'Sylhet', 'daily_limit' => 120],
                ['center_name' => 'Barisal Sher-e-Bangla Medical College', 'location' => 'Barisal', 'daily_limit' => 110],
                ['center_name' => 'Dinajpur Medical College', 'location' => 'Dinajpur', 'daily_limit' => 100],
                ['center_name' => 'Pabna Medical College', 'location' => 'Pabna', 'daily_limit' => 90],
                ['center_name' => 'Cox\'s Bazar Medical College', 'location' => 'Cox\'s Bazar', 'daily_limit' => 80],

                ['center_name' => 'Mymensingh Medical College', 'location' => 'Mymensingh', 'daily_limit' => 160],
                ['center_name' => 'Narsingdi Medical College', 'location' => 'Narsingdi', 'daily_limit' => 150],
            ]);
        } else {
            // Optionally log or inform that centers already exist
            echo "Vaccine centers already exist in the database. Skipping insertion.\n";
        }
    }
}
