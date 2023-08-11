<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymobController extends Controller
{
     public function callback(Request $request){
     $data= $request['obj'];
	 $status=$data['success'];
	
	return response([
		'status'=>$status
		]);
	
       /*  if($transaction->isSuccessful()){
            if($request->session()->has('payment_type')){
                if($request->session()->get('payment_type') == 'cart_payment'){
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(Session::get('order_id'), json_encode($response));
                }
                elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                    $walletController = new WalletController;
                    return $walletController->wallet_payment_done(Session::get('payment_data'), json_encode($response));
                }
            }
        }else if($transaction->isFailed()){
            $request->session()->forget('order_id');
            $request->session()->forget('payment_data');
            flash(__('Payment cancelled'))->error();
        	return back();
        }else if($transaction->isOpen()){
          //Transaction Open/Processing
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id */
    }
}
