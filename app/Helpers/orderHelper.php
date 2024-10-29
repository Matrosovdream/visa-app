<?php
namespace App\Helpers;

class orderHelper {

    public static function getProgress( $order ) {

        $status = $order->status->name;
        $progress = 0;
        switch ($status) {
            case 'Pending':
                $progress = 1;
                break;
            case 'Processing':
                $progress = 3;
                break;
            case 'Completed':
                $progress = 4;
                break;
        }

        return $progress;

    }

}