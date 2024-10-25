<?php
namespace App\Mixins\Gateways;

use Omnipay\Omnipay;
use Exception;

class AuthnetGateway
{
    
    public $params;
    public $gateway;
    public $response;
    public $transaction_id;
    public $errors = [];
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
        $this->gateway->setAuthName(env('ANET_API_LOGIN_ID'));
        $this->gateway->setTransactionKey(env('ANET_TRANSACTION_KEY'));
        $this->gateway->setTestMode(true); //comment this line when move to 'live'
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function charge()
    {

        try {

            // Set credit card
            $creditCard = $this->setCreditCard();

            // Authorize
            $authResponse = $this->authorize($creditCard);

            // Set global response
            $this->response = $authResponse;

            // Process response
            $this->processResponse();

            // Check if the authorization was successful
            if($authResponse->isSuccessful()) {

                $refId = $this->response->getData()['refId'];

                // Capture 
                $captureResponse = $this->capture($refId );

                //dd($refId );

                // Set global response
                $this->response = $captureResponse;

                // Process response
                $this->processResponse();
 
                // Check if the capture was successful
                $transaction_id = $captureResponse->getTransactionReference();
                
            } else {
                // not successful
                $this->setError( $authResponse->getMessage() );
            }
        } catch(Exception $e) {
            $this->setError( $e->getMessage() );
        }

    }

    private function authorize($creditCard)
    {

        $this->transaction_id = $this->makeTransactionId();

        return $this->gateway->authorize([
            'amount' => $this->params['order_data']['amount'],
            'currency' => $this->params['order_data']['currency'],
            'card' => $creditCard,
            'transactionId' => $this->transaction_id,
        ])->send();
    }

    private function capture($transactionReference)
    {
        return $this->gateway->capture([
            'amount' => $this->params['order_data']['amount'],
            'currency' => $this->params['order_data']['currency'],
            'transactionReference' => $transactionReference,
        ])->send();
    }

    private function setCreditCard()
    {
        return new \Omnipay\Common\CreditCard([
            'number' => $this->params['cart_data']['cc_number'],
            'expiryMonth' => $this->params['cart_data']['expiry_month'],
            'expiryYear' => $this->params['cart_data']['expiry_year'],
            'cvv' => $this->params['cart_data']['cvv'],
        ]);
    }

    private function processResponse()
    {
        if( $this->response->isSuccessful() ) {
            // success
        } else {
            $this->setError( $this->response->getMessage() );
        }
    }

    private function makeTransactionId()
    {
        return rand(100000000, 999999999);
    }

    private function setError( $error )
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isErrors()
    {
        return count($this->errors) > 0;
    }

    public function getResponse()
    {
        if( isset($this->response) ) {
            return $this->response->getData();
        } 
    }
    

}