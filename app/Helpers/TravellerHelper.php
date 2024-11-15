<?php
namespace App\Helpers;

use App\Models\Traveller;
use App\Models\File;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;

class TravellerHelper
{

    public static function preparePostTraveller($data)
    {

        $groupedData = [];
        foreach ($data as $key => $values) {
            foreach ($values as $index => $value) {
                $groupedData[$index][$key] = $value;
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

    public static function isCompletedForm($traveller)
    {

        $fields = self::getRequiredFields($traveller->id);

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

        // Check documents, should be uploaded at least one
        if( count( $traveller->documents ) == 0) {
            return false;
        }

        return true;

    }

    public static function getRequiredFields($traveller_id)
    {

        $traveller = Traveller::find($traveller_id);
        $order = $traveller->orders()->first();

        $fields_main = [
            'name',
            'lastname',
            'birthday',
            'passport',
        ];

        // Retrieve all required fields
        $all_fields = self::getTravellerFieldList();
        foreach( $all_fields as $cat => $fields ) {
            foreach( $fields as $field_code => $field ) {
                if( 
                    isset($field['required']) && 
                    $field['required'] &&
                    $field['relate'] == 'meta'
                    ) {
                    $fields_meta[] = $field_code;
                }
            }
        }

        return [
            'main' => $fields_main,
            'meta' => $fields_meta,
        ];

    }

    public static function getTravellerFieldList($traveller_id = null, $product_id = null)
    {

        $cats = self::getTravellerFieldCategories();

        $fields = [
            'personal' => [
                'residence_country' => [
                    'title' => 'Country of Residence', 'type' => 'select', 'required' => true, 'options' => self::getReference('countries'), 'relate' => 'meta'],
                'gender' => ['title' => 'Gender', 'type' => 'select', 'required' => true,'options' => self::getReference('gender'), 'relate' => 'meta'],
                //'nationality' => ['title' => 'Nationality', 'type' => 'boolean', 'relate' => 'meta'],
                'residence_address' => ['icon' => 'location-2.svg','title' => 'Residence address', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'residence_city' => ['icon' => 'location-2.svg','title' => 'Residence city or Town', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'residence_state' => ['icon' => 'location-2.svg','title' => 'Residence state or province', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'residence_zip' => ['icon' => 'location-2.svg','title' => 'Residence ZIP code', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
                'occupation' => ['icon' => 'user.svg','title' => 'Occupation', 'type' => 'text', 'required' => true, 'relate' => 'meta'],
            ],
            'passport' => [
                'name' => ['icon' => 'user.svg','title' => 'Name', 'type' => 'text', 'required' => true, 'relate' => 'entity'],
                'lastname' => ['icon' => 'user.svg','title' => 'Last name', 'type' => 'text', 'required' => true, 'relate' => 'entity'],
                'birthday' => ['icon' => 'user.svg','title' => 'Birthday', 'type' => 'date', 'required' => true, 'relate' => 'entity'],
                'passport' => ['icon' => 'user.svg','title' => 'Passport', 'type' => 'text', 'required' => true, 'relate' => 'entity'],
                'passport_issue_date' => ['icon' => 'user.svg','title' => 'Passport Issue Date', 'type' => 'date', 'required' => true, 'relate' => 'meta'],
                'passport_expiration_date' => ['icon' => 'user.svg','title' => 'Passport Expiration Date', 'type' => 'date', 'required' => true, 'relate' => 'meta'],
                'birth_country' => ['title' => 'Country of Birth', 'type' => 'select', 'required' => true, 'options' => self::getReference('countries'), 'relate' => 'meta'],
                'passport_issue_country' => ['title' => 'Which country issued your passport', 'type' => 'select', 'required' => true, 'options' => self::getReference('countries'), 'relate' => 'meta'],
            ],
            'family' => [
                'marital_status' => ['title' => 'Marital status', 'type' => 'select', 'required' => true, 'options' => self::getReference('marital_status'), 'relate' => 'meta'],
            ],
            'past_travel' => [
                'past_travel_country' => ['title' => 'Have you previously visited country?', 'type' => 'select', 'required' => true, 'options' => self::getReference('boolean'), 'relate' => 'meta'],
                'past_travel_date' => ['icon' => 'location-2.svg','title' => 'When did you arrive?', 'type' => 'date', 'required' => false, 'relate' => 'meta'],
                'past_travel_departure' => ['icon' => 'location-2.svg','title' => 'When did you depart?', 'type' => 'date', 'required' => false, 'relate' => 'meta'],
            ],
            'declarations' => [
                'is_previous_country_deport' => ['icon' => 'location-2.svg','title' => 'Have you ever been deported from country or another country?', 'type' => 'select', 'required' => true, 'options' => self::getReference('boolean'), 'relate' => 'meta'],
            ],
        ];

        // Set an empty value for all
        foreach ($fields as $cat => $field) {
            foreach ($field as $field_code => $data) {
                $fields[$cat][$field_code]['value'] = '';
            }
        }

        // if isset traveller_id then fill in the array with values
        if ($traveller_id) {
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
                            // If it's select then take the value from the
                            if ($data['type'] == 'select') {
                                foreach ($data['options'] as $option) {
                                    if ($option['value'] == $traveller->getMeta($field_code)) {
                                        $fields[$cat][$field_code]['valueModel'] = $option;
                                        break;
                                    }
                                }
                            }

                            $fields[$cat][$field_code]['value'] = $traveller->getMeta($field_code);
                            break;
                    }

                }
            }
        }

        //dd($fields);

        return $fields;

    }

    public static function getReference($ref_code)
    {

        $references = [
            'countries' => self::prepareCountryRef(),
            'gender' => self::prepareGenderRef(),
            'marital_status' => self::prepareMaritalStatusRef(),
            'boolean' => self::prepareBooleanRef(),
        ];
        return $references[$ref_code];

    }

    public static function prepareBooleanRef()
    {

        $boolean = [
            ['value' => 'yes', 'title' => 'Yes'],
            ['value' => 'no', 'title' => 'No'],
        ];
        return $boolean;

    }

    public static function prepareCountryRef()
    {

        $countries = Country::all();
        $countriesRef = [];
        foreach ($countries as $country) {
            $countriesRef[] = [
                'value' => $country->id,
                'title' => $country->name,
            ];
        }

        return $countriesRef;

    }

    public static function prepareGenderRef()
    {

        $genders = [
            ['value' => 'male', 'title' => 'Male'],
            ['value' => 'female', 'title' => 'Female'],
        ];
        return $genders;

    }

    public static function prepareMaritalStatusRef()
    {

        $statuses = [
            ['value' => 'single', 'title' => 'Single'],
            ['value' => 'married', 'title' => 'Married'],
            ['value' => 'divorced', 'title' => 'Divorced'],
            ['value' => 'widowed', 'title' => 'Widowed'],
        ];
        return $statuses;

    }


    public static function getTravellerFieldListAll()
    {

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

    public static function getTravellerField($field_code)
    {

        $fields = self::getTravellerFieldListAll();
        return $fields[$field_code];

    }

    public static function updateTravellerField($applicant_id, $field, $value)
    {

        $traveller = Traveller::find($applicant_id);

        //dd($field['code']);

        switch ($field['relate']) {
            case 'entity':
                $traveller->{$field['code']} = $value;
                $traveller->save();
                break;
            case 'file':
                // Upload file from request
                $file_raw = request()->file('fields.' . $field['code']);

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

    public static function getTravellerFieldCategories()
    {

        $cats = [
            'personal' => ['title' => __('Personal'), 'slug' => 'personal', 'route' => 'web.account.order.applicant.personal'],
            'passport' => ['title' => __('Passport'), 'slug' => 'passport', 'route' => 'web.account.order.applicant.passport'],
            'family' => ['title' => __('Family'), 'slug' => 'family', 'route' => 'web.account.order.applicant.family'],
            'past_travel' => ['title' => __('Past Travel'), 'slug' => 'past_travel', 'route' => 'web.account.order.applicant.past-travel'],
            'declarations' => ['title' => __('Declarations'), 'slug' => 'declarations', 'route' => 'web.account.order.applicant.declarations'],
        ];

        return $cats;

    }

    public static function uploadDocument($applicant_id, $request_file, $data = [])
    {

        $path = 'uploads/travellers/'.$applicant_id;
        $disk = 'local';

        $file = request()->file($request_file);
        $filename = $file->getClientOriginalName();
        $filesize = $file->getSize();
        $type = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();

        // We set an origin filename to the file
        $filePath = request()->file($request_file)->storeAs($path, $filename, $disk);

        // Insert into the database
        $file = new File();
        $file->filename = $filename;
        $file->path = $filePath;
        $file->type = $type;
        $file->size = $filesize;
        $file->extension = $extension;
        $file->description = '';
        $file->disk = $disk;
        $file->visibility = 'private';
        $file->user_id = auth('')->user()->id;
        $file->save();

        // Save the file path in the database
        $traveller = Traveller::find($applicant_id);
        $traveller->documents()->create([
            'file_id' => $file->id,
        ]);

    }

}