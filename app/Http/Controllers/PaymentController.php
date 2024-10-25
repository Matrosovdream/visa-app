<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\OrderPayment;
use Exception;
use App\Mixins\Order\OrderPaymentProcesser;
 
class PaymentController extends Controller
{

    public function index()
    {
        return view('payment');
    }
 
    public function charge(Request $request)
    {

        // Validate request
        $request->validate([
            'order_id' => 'required',
            'cc_number' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'cvv' => 'required',
        ]);

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
        $res = $orderPayment->charge();

        if( $res['status'] == 'failed' ) {
            return redirect()->back()->with('error', $res['errors']);
        } else {
            return redirect()->back()->with('success', 'Payment successful');
        }

    }

}