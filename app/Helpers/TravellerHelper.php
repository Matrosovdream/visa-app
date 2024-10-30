<?php
namespace App\Helpers;

use App\Models\Traveller;

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

    public static function isCompletedForm( $traveller )
    {

        $fields = self::getRequiredFields( $traveller->id );

        // Check main fields
        foreach ($fields['main'] as $field) {
            if (empty($traveller->$field)) {
                return false;
            }
        }

        // Check meta fields
        foreach ($fields['meta'] as $field) {
            if (empty($traveller->getMeta($field))) {
                return false;
            }
        }

        return true;
        
    }

    public static function getRequiredFields( $traveller_id ) {

        $traveller = Traveller::find($traveller_id);
        $order = $traveller->orders()->first();

        $fields_main = [
            'name',
            'lastname',
            'birthday',
            'passport',
        ];

        $fields_meta = [
            'passport_expiration_day',
            'passport_expiration_month',
            'passport_expiration_year',
        ];

        return [
            'main' => $fields_main,
            'meta' => $fields_meta,
        ];

    }

}