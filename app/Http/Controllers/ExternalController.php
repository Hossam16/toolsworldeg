<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use App\SimpleXLSX;
use Excel;
use Illuminate\Support\Str;
use App\Product;
use App\ProductTranslation;
use App\ProductStock;
class ExternalController extends Controller
{
    
    
		 public function index()
    {
       
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('backend.product.bulk_update.index');
        }
    }
		 
public function bulk_upload_stock(Request $request){
	
	 $user=\Auth::user();
	 $date = date('Y-m-d', strtotime('-5 hours'));
	 $rules = array(
             'upload_file' => 'required',
			   );
        $messages= array();
        $this->validate(request(), $rules,$messages);
		  $logo_name = 'none';
        if(isset($request->upload_file)){
            $logo = $request->file('upload_file');
            $logo_name = time().'.'.$logo->getClientOriginalExtension();

            $destinationPath = public_path('/uploads/products/update');
            $logo->move($destinationPath, $logo_name);
            $logo_name = $logo_name;
        } $i=0;
	if ( $xlsx = SimpleXLSX::parse('/home/toolswor/public_html/public/uploads/products/update/'.$logo_name) ) {

	foreach( $xlsx->rows() as $r ) {
		
	
		
		$sku=(string)$r[2];
		$qty=$r[0];
		
$product = Product::where('sku',$sku)->update(array(
	'current_stock'=>$qty
	));
if(!empty($product)){$i++;}
	
	
	
	
	}
	}else {
	echo SimpleXLSX::parseError();
	}
	 flash('َStock of ('.$i.') Product has been Updated successfully')->success();		
return redirect()->route('product_bulk_update.index');
    }
		
public function bulk_upload_price(Request $request){
		 $user=\Auth::user();
	 $date = date('Y-m-d', strtotime('-5 hours'));
	 $rules = array(
             'upload_file' => 'required',
			   );
        $messages= array();
        $this->validate(request(), $rules,$messages);
		  $logo_name = 'none';
        if(isset($request->upload_file)){
            $logo = $request->file('upload_file');
            $logo_name = time().'.'.$logo->getClientOriginalExtension();

            $destinationPath = public_path('/uploads/products/update');
            $logo->move($destinationPath, $logo_name);
            $logo_name = $logo_name;
        } 
		$i=0;
	if ( $xlsx = SimpleXLSX::parse('/home/toolswor/public_html/public/uploads/products/update/'.$logo_name) ) {


	foreach( $xlsx->rows() as $r ) {
		
		$sku=(string)$r[1];
		$price=$r[0];
		//echo $sku;echo '-';
		$product = Product::where('sku',$sku)->first();
		if(!empty($product)){
		//	echo $product->id;echo '-';
		$product->unit_price=$price;
		$product->save();
					$i++;
					}

	
	}
	}else {
	echo SimpleXLSX::parseError();
	
}
 flash('Prices of ('.$i.') Product has been Updated successfully')->success();		
return redirect()->route('product_bulk_update.index');
    }
public static function set_tire_status($sku,$qty){
		if($qty > 10 ){
	
DB::table('Shop_Tires')
	->where('T_sku',$sku)
	->limit(1)
	->update(array(
	'T_status'=>'active'
	));
	}
	return true;
}

public static function set_tire_price($sku,$qty,$price){
	$tire=Vendor_tire::where('tire_id',$sku)->where('qty','>',0)->where('price','<=',$price)->orderBy('price','ASC')->first();
	if(!empty($tire)){
		$price=$tire->price;
	}
	if($qty > 10 ){
		Vendor_tire::where('tire_id',$sku)->update(array(
		'best'=>0
		));
	Vendor_tire::where('v_id',$tire->v_id)->update(array(
		'best'=>1
		));
	
DB::table('Shop_Tires')
	->where('T_sku',$sku)
	->limit(1)
	->update(array(
	'T_status'=>'active',
	'T_price'=>$price
	));

	}
	return true;
}


public function deleter($id){
	DB::table('Shop_Tires_sizes')->where('TS_id', $id)->delete();
	
//$x5x=\App\Http\Controllers\logController::insert_log("delete","","","Products",$id);	

        return redirect('Admin/Data_Tire/Size');
    }


}
