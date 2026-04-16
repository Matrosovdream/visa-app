<?php
namespace App\Helpers;

use App\Models\Geo\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class countryHelper
{
    public static function createPairs()
    {
        $countries = Country::all();
        $batchInsert = [];

        $directions = self::getDirectionsRef();

        foreach ($countries as $i => $countryFrom) {
            for ($j = $i + 1; $j < count($countries); $j++) {
                $countryTo = $countries[$j];

                $name = $countryFrom->name . ' - ' . $countryTo->name;
                $slug = Str::slug($name);

                $batchInsert[] = [
                    'name' => $name,
                    'slug' => $slug,
                    'country_from_id' => $countryFrom->id,
                    'country_to_id' => $countryTo->id,
                    'country_from_code' => $countryFrom->code,
                    'country_to_code' => $countryTo->code,
                    'visa_req' => $directions[$slug]['visa_req'],
                ];

                $name = $countryTo->name . ' - ' . $countryFrom->name;
                $slug = Str::slug($name);

                $batchInsert[] = [
                    'name' => $name,
                    'slug' => $slug,
                    'country_from_id' => $countryTo->id,
                    'country_to_id' => $countryFrom->id,
                    'country_from_code' => $countryTo->code,
                    'country_to_code' => $countryFrom->code,
                    'visa_req' => $directions[$slug]['visa_req'],
                ];

                if (count($batchInsert) >= 5000) {
                    DB::table('travel_directions')->insert($batchInsert);
                    $batchInsert = [];
                }
            }
        }

        if (!empty($batchInsert)) {
            DB::table('travel_directions')->insert($batchInsert);
        }
    }

    public static function cleanPairs()
    {
        DB::table('travel_directions')->truncate();
    }

    public static function getDirectionsRef()
    {
        $directions = json_decode(file_get_contents(database_path('references/travel_directions.json')), true);

        $set = [];
        foreach ($directions as $direction) {
            $set[$direction['slug']] = $direction;
        }

        return $set;
    }
}
