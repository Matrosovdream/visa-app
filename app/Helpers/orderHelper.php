<?php
namespace App\Helpers;

class orderHelper {

    public static function getProgress( $order ) {

        $status = $order->status->slug;
        $progress = 0;
        switch ($status) {
            case 'pending':
                $progress = 1;
                break;
            case 'processing':
                $progress = 2;
                break;
            case 'completed':
                $progress = 3;
                break;
        }

        return $progress;

    }

}