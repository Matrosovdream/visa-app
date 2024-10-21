<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\OrderPayment;
use Exception;
 
class PaymentController extends Controller
{
    public $gateway;
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        $this->gateway->setAuthName(env('ANET_API_LOGIN_ID'));
        $this->gateway->setTransactionKey(env('ANET_TRANSACTION_KEY'));
        $this->gateway->setTestMode(true); //comment this line when move to 'live'
    }
 
    public function index()
    {
        return view('payment');
    }
 
    public function charge(Request $request)
    {
        try {
            $creditCard = new \Omnipay\Common\CreditCard([
                'number' => $request->input('cc_number'),
                'expiryMonth' => $request->input('expiry_month'),
                'expiryYear' => $request->input('expiry_year'),
                'cvv' => $request->input('cvv'),
            ]);
 
            // Generate a unique merchant site transaction ID.
            $transactionId = rand(100000000, 999999999);
 
            $response = $this->gateway->authorize([
                'amount' => $request->input('amount'),
                'currency' => 'USD',
                'transactionId' => $transactionId,
                'card' => $creditCard,
            ])->send();
 
            if($response->isSuccessful()) {
 
                // Captured from the authorization response.
                $transactionReference = $response->getTransactionReference();

                dd($transactionReference);
 
                $response = $this->gateway->capture([
                    'amount' => $request->input('amount'),
                    'currency' => 'USD',
                    'transactionReference' => $transactionReference,
                    ])->send();
 
                $transaction_id = $response->getTransactionReference();
                $amount = $request->input('amount');
 
                // Insert transaction data into the database
                $payment = new OrderPayment;
                $payment->user_id = $request->input('user_id');
                $payment->order_id = $request->input('order_id');
                $payment->payment_gateway_id = $request->input('payment_gateway_id');
                $payment->transaction_id = $transaction_id;
                $payment->status = 'Captured';
                $payment->currency = 'USD';
                $payment->amount = $request->input('amount');
                $payment->response = json_encode($response->getData());
                $payment->save();

                return "Payment is successful. Your transaction id is: ". $transaction_id;
            } else {
                // not successful
                return $response->getMessage();
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}