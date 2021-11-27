<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Srmklive\PayPal\Service\PayPal;

class PaypalController extends Controller
{
    public function create(Request $request){
        $data = json_decode($request->getContent(), true);

        //init paypal
        $provider = \Srmklive\PayPal\Facades\PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        //set product data
        $price = Order::getProductPrice($data['value']);
        $description = Order::getProductDescription($data['value']);
        
        $order = $provider->createOrder([
            "intent"=> "CAPTURE",
            "purchase_units"=> [
                [
                    "amount"=> [
                        "currency_code"=> "USD",
                        "value"=> $price,
                    ],
                    "description"=>$description
                ]
            ]
        ]);
        
        return response()->json($order);
    }

    public function capture(Request $request){
        $data = json_decode($request->getContent(), true);
        $orderId = $data['orderId'];

        //init paypal
        $provider = \Srmklive\PayPal\Facades\PayPal::setProvider();
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $result = $provider->capturePaymentOrder($orderId);

        //update database

        return response()->json($result);
    }
}
