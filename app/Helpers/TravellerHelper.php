<?php
namespace App\Helpers;

use App\Models\Traveller;
use App\Models\File;

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

    public static function getTravellerFieldList( $traveller_id=null, $product_id=null ) {

        $cats = self::getTravellerFieldCategories();

        $fields = [
            'passport' => [
                'passport' => ['title' => 'Passport', 'type' => 'text', 'required' => true, 'relate' => 'entity'],
                'passport_expiration_day' => ['title' => 'Passport Expiration Day', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'passport_expiration_month' => ['title' => 'Passport Expiration Month', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'passport_expiration_year' => ['title' => 'Passport Expiration Year', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
            ],
            'family' => [
                'family_name' => ['title' => 'Family Name', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'family_file' => ['title' => 'Family File', 'type' => 'file', 'required' => true, 'relate' => 'file'],
                'family_lastname' => ['title' => 'Family Lastname', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'family_birthday' => ['title' => 'Family Birthday', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
            ],
            'past_travel' => [
                'past_travel_country' => ['title' => 'Past Travel Country', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'past_travel_date' => ['title' => 'Past Travel Date', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
            ],
            'declarations' => [
                'declaration' => ['title' => 'Declaration', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
            ],
        ];

        // if isset traveller_id then fill in the array with values
        if( $traveller_id ) {
            $traveller = Traveller::find($traveller_id);
            foreach ($fields as $cat => $field) {
                foreach ($field as $field_code => $data) {

                    switch ($data['relate']) {
                        case 'entity':
                            $fields[$cat][$field_code]['value'] = $traveller->{$field_code};
                        break;
                        case 'file':
                            $fileId = $traveller->getMeta($field_code);
                            $fields[$cat][$field_code]['value'] = File::find($fileId);
                        break;
                        case 'meta':
                            $fields[$cat][$field_code]['value'] = $traveller->getMeta($field_code);
                        break;
                    }

                }
            }
        }

        return $fields;

    }

    public static function getTravellerFieldListAll() {

        $cats = self::getTravellerFieldList();

        $allFields = [];
        foreach ($cats as $cat => $fields) {
            foreach ($fields as $field_code => $data) {
                $data['code'] = $field_code;
                $allFields[$field_code] = $data;
            }
        }

        return $allFields;

    }

    public static function getTravellerField($field_code) {

        $fields = self::getTravellerFieldListAll();
        return $fields[$field_code];

    }

    public static function updateTravellerField($applicant_id, $field, $value) {

        $traveller = Traveller::find($applicant_id);

        //dd($field['code']);

        switch ($field['relate']) {
            case 'entity':
                $traveller->{$field['code']} = $value;
                $traveller->save();
            break;
            case 'file':
                // Upload file from request
                $file_raw = request()->file( 'fields.'.$field['code'] );

                // Save file
                $file = $file_raw->store('public/files');

                // Save file using Files model
                $fileModel = new File();
                $fileModel->filename = $file_raw->getClientOriginalName();
                $fileModel->path = $file;
                $fileModel->type = 'general';
                $fileModel->size = $file_raw->getSize();
                $fileModel->extension = $file_raw->getClientOriginalExtension();
                $fileModel->visibility = 'private';
                $fileModel->save();

                $traveller->setMeta($field['code'], $fileModel->id);

                break;
            case 'meta':
                $traveller->setMeta($field['code'], $value);
            break;
        }

    }            

    public static function getTravellerFieldCategories() {

        $cats = [
            'passport' => ['title' => __('Passport'), 'route' => 'web.account.order.applicant.passport'],
            'family' => ['title' => __('Family'), 'route' => 'web.account.order.applicant.family'],
            'past_travel' => ['title' => __('Past Travel'), 'route' => 'web.account.order.applicant.past-travel'],
            'declarations' => ['title' => __('Declarations'), 'route' => 'web.account.order.applicant.declarations'],
        ];

        return $cats;

    }

}