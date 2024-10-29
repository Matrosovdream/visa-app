<?php
namespace App\Actions\Web;

use App\Mixins\Order\OrderPaymentProcesser;

class PaymentActions
{
    public static function processPayment($request)
    {

        // Prepare payment data
        $params = [];
        $params['cart_data'] = [
            'cc_number' => $request->input('cc_number'),
            'expiry_month' => $request->input('expiry_month'),
            'expiry_year' => $request->input('expiry_year'),
            'cvv' => $request->input('cvv'),
        ];

        // Init payment
        $orderPayment = new OrderPaymentProcesser( $request->input('order_id'), $params);

        // Process payment
        return $orderPayment->charge();

    }
}