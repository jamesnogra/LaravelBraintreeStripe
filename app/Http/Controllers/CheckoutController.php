<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

use Braintree_Transaction;

class CheckoutController extends Controller
{
    public function stripeCharge(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));
        
            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => 99,
                'currency' => 'usd'
            ));
        
            return [
                'message'       => 'Charge for card is successful!',
                'id'            => $charge->id,
                'amount'        => $charge->amount,
                'currency'      => $charge->currency,
                'email'         => $charge->billing_details->name,
            ];
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function braintreeCharge(Request $request)
    {
        $payload = $request->input('payload', false);
        $nonce = $payload['nonce'];

        $status = Braintree_Transaction::sale([
            'amount' => '0.99',
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        return response()->json($status);
    }

    public function braintreeSuccessMessage(Request $request)
    {
        return [
            'message'       => 'Charge for card is successful!',
            'currency'      => $request->currency,
            'amount'        => $request->amount,
        ];
    }
}
