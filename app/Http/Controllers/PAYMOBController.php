<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\BusinessSetting;
use App\Seller;
use Session;
use App\CustomerPackage;
use App\SellerPackage;
use Stripe\Stripe;
use App\Http\Controllers\CheckoutController;
class PAYMOBController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function PAYMOB(Request $request)
    {
		$ch = curl_init();
$headers  = [
            
            'Content-Type: application/json'
        ];
$postData = [
    'api_key' => env('PAYMOB_API_KEY',"ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SnVZVzFsSWpvaWFXNXBkR2xoYkNJc0ltTnNZWE56SWpvaVRXVnlZMmhoYm5RaUxDSndjbTltYVd4bFgzQnJJam94TkRJeE16RjkuSmhGS0lMSnY3RlNTVTFCYUJYa01zQlhDeENBeE5OLXQ3MUp4R3ZsZXZFdWFKVE5LQnNNUHpfQklXdkRpcVluWE1DZkppa2hrNGRDTWxiOF9laG9UeFE=")
    
];
curl_setopt($ch, CURLOPT_URL,"https://accept.paymobsolutions.com/api/auth/tokens");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$output = curl_exec($ch);
curl_close($ch);

$jsonArrayResponse = json_decode($output);

$token=$jsonArrayResponse->token;



	
		
		
		
        $amount = 0;
        if($request->session()->has('payment_type')){
            if($request->session()->get('payment_type') == 'cart_payment'){
                $order = Order::findOrFail(Session::get('order_id'));
                $amount = round($order->grand_total * 100);
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $amount = round($request->session()->get('payment_data')['amount'] * 100);
            }
            elseif ($request->session()->get('payment_type') == 'customer_package_payment') {
                $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);
                $amount = round($customer_package->amount * 100);
            }
            elseif ($request->session()->get('payment_type') == 'seller_package_payment') {
                $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
                $amount = round($seller_package->amount * 100);
            }
        }


	$ch2 = curl_init();
$headers2  = [
            
            'Content-Type: application/json'
        ];
$postData2 = [
    'auth_token' => $token,
 'delivery_needed' => 'false',
 'amount_cents' => $amount,
 'currency' => 'EGP',
 'merchant_order_id'=>Session::get('order_id')

    
];
curl_setopt($ch2, CURLOPT_URL,"https://accept.paymobsolutions.com/api/ecommerce/orders");
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($postData2));           
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
$output2 = curl_exec($ch2);
curl_close($ch2);

$jsonArrayResponse2 = json_decode($output2);
$order_id=$jsonArrayResponse2->id;




 	$ch3 = curl_init();
$headers3  = [
            
            'Content-Type: application/json'
        ];
$postData3 = [
		'auth_token' => $token,
		'amount_cents' => $amount,
		'expiration' => 3600,
		'order_id' =>$order_id,
		'billing_data'=>[
		'apartment'=>'NA',
		'email'=>'hany_ahmed088@yahoo.com',
		'floor'=>'NA',
		'first_name'=>'hany',
		'last_name'=>'ahmed',
		'street'=>'hany',
		'building'=>'hany',
		'phone_number'=>'01126839628',
		'shipping_method'=>'PKG',
		'postal_code'=>'NA',
		'city'=>'NA',
		'country'=>'NA',
		'state'=>'NA'
		],
		
		'currency' => 'EGP',
		'integration_id' =>env('PAYMOB_MERCHANT_ID', "1719558"),
		'lock_order_when_paid'=>'false'
     
];
curl_setopt($ch3, CURLOPT_URL,"https://accept.paymobsolutions.com/api/acceptance/payment_keys");
curl_setopt($ch3, CURLOPT_POST, 1);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch3, CURLOPT_POSTFIELDS, json_encode($postData3));           
curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers3);
$output3 = curl_exec($ch3);
curl_close($ch3);

$jsonArrayResponse3 = json_decode($output3);

 $paytoken=$jsonArrayResponse3->token;


		//$token='ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SndjbTltYVd4bFgzQnJJam94TkRZME16Y3NJbkJvWVhOb0lqb2lPV05rWkRKaVpHVmlOMlV6T1ROa09HWTFPVFF6Tmpoak5UUmpZekpoTURoak56SmpZVEEwWW1Vd05UZ3pPVFV5TWpZMlpUY3hZall4WVdNNE1qWTVOQ0lzSW1Oc1lYTnpJam9pVFdWeVkyaGhiblFpTENKbGVIQWlPakUyTXprNE56RXlNVGQ5LjBINUVic3ZyQkRrc21SaXIyMTRtbnJLUkZ2UEV6RWNxV2VhV3FQUW5xZUxLTkJKVjN5bjRSVzNNQW11eU9ER3M3LTlIWDJCRExxMzdkU1N2TzlCSVFn';
      return view('frontend.payment.baymob')->with('token',$paytoken);
    }
 public function callback(Request $request){
     $status= $request->success;
	
	
	if($status=='true'){
		return PAYMOBController::success($request->merchant_order_id);
	}else{
		return PAYMOBController::cancel();
	}
	
     
    }
 public function success($id) {
      // return view('frontend.order_confirmed');
		
		try{
			$payment = ["status" => "Success"];
			$checkoutController = new CheckoutController;
			return $checkoutController->checkout_done($id, json_encode($payment));
			  
		}
        catch (\Exception $e) {
            flash(translate('Payment failed'))->error();
    	    return redirect()->route('home');
        }
    }



   
    public function cancel(Request $request){
        flash(translate('Payment is cancelled'))->error();
        return redirect()->route('home');
    }
}
