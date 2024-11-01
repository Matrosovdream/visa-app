<?php
namespace App\Actions\Web;

use App\Helpers\TravellerHelper;

class OrderApplicantActions
{
    public static function fieldsUpdate($request, $order_id, $applicant_id)
    {

        foreach( $request->fields as $field => $value ) {
            
            // Get field
            $field = TravellerHelper::getTravellerField($field);

            // Validate field and Update field
            if( isset($field) ) {
                TravellerHelper::updateTravellerField($applicant_id, $field, $value);
            } 

        }
        
        return ;
    }



}