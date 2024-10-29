<?php
namespace App\Helpers;

class TravellerHelper
{
    public static function preparePostTraveller($data)
    {

        $groupedData = [];
        foreach ($data as $key => $values) {
            foreach ($values as $index => $value) {
                $groupedData[$index][ $key] = $value;
            }
        }

        $newData = [];
        foreach ($groupedData as $key => $values) {
            $newData[] = self::prepareTraveller($values);
        }

        return $newData;

    }

    public static function prepareTraveller($values)
    {
        // Prepare Traveller fields
        $travellers_fields = [
            'full_name' => $values['name'] . ' ' . $values['lastname'],
            'name' => $values['name'],
            'lastname' => $values['lastname'],
            'birthday' => $values['birthday'],
            'passport' => $values['passport'],
        ];

        // Meta fields
        $meta_fields = [];
        $meta_fields[] = ['key' => 'passport_expiration_day', 'value' => $values['passport-expiration-day']];
        $meta_fields[] = ['key' => 'passport_expiration_month', 'value' => $values['passport-expiration-month']];
        $meta_fields[] = ['key' => 'passport_expiration_year', 'value' => $values['passport-expiration-year']];


        return [
            'traveller' => $travellers_fields,
            'meta' => $meta_fields,
        ];

    }

}