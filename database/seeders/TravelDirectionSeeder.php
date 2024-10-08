<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\countryHelper;

class TravelDirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Clean up the table
        countryHelper::cleanPairs();

        // Seed the table
        countryHelper::createPairs();

    }
}
