<?php
namespace App\Helpers;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class countryHelper
{
    public static function createPairs()
    {
        $countries = Country::all(); // Fetch all countries
        $batchInsert = []; // Array to hold batch insert data

        foreach ($countries as $i => $countryFrom) {
            for ($j = $i + 1; $j < count($countries); $j++) {
                $countryTo = $countries[$j];
                
                // Prepare name and slug
                $name = $countryFrom->name . ' - ' . $countryTo->name;
                $slug = Str::slug($name);
                
                // Add the combination to the batch insert array
                $batchInsert[] = [
                    'name' => $name,
                    'slug' => $slug,
                    'country_from_id' => $countryFrom->id,
                    'country_to_id' => $countryTo->id,
                    'country_from_code' => $countryFrom->code,
                    'country_to_code' => $countryTo->code
                ];

                // Reverse
                $name = $countryTo->name . ' - ' . $countryFrom->name;
                $slug = Str::slug($name);

                $batchInsert[] = [
                    'name' => $name,
                    'slug' => $slug,
                    'country_from_id' => $countryTo->id,
                    'country_to_id' => $countryFrom->id,
                    'country_from_code' => $countryFrom->code,
                    'country_to_code' => $countryTo->code
                ];

        
                // Optional: Flush the insert to avoid huge memory usage in case of many records
                if (count($batchInsert) >= 5000) { // Insert every 1000 rows
                    DB::table('travel_directions')->insert($batchInsert);
                    $batchInsert = []; // Clear the batch insert array
                }
            }
        }
        
        // Insert any remaining records after the loop
        if (!empty($batchInsert)) {
            DB::table('travel_directions')->insert($batchInsert);
        }
    }

    public static function cleanPairs()
    {
        DB::table('travel_directions')->truncate();
    }

}