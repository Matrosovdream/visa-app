<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{

    public function run(): void
    {

        // Retrieve the countries from the JSON file
        $countries = json_decode(file_get_contents(database_path('references/countries.json')), true);

        // Insert the countries into the database
        foreach ($countries as $country) {

            Country::firstOrCreate([
                'name' => $country['name'],
                'code' => $country['code'],
                'slug' => Str::slug($country['name'])
            ]);
        }

    }
}
