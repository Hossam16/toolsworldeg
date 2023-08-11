<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Extraprice;
use App\HomeCategory;
use App\Product;
use App\Language;
use App\CategoryTranslation;
use App\Utility\CategoryUtility;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;
class AddpriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
       // $categories = Extraprice::join('category_translations','category_translations.category_id','extra_prices.category_id')->select('extra_prices.*','category_translations.name')->where('lang',env('DEFAULT_LANGUAGE'))->orderBy('created_at', 'asc');
       $categories = Extraprice::join('users','users.id','extra_prices.created_by')->select('extra_prices.*','users.name as user')->orderBy('created_at', 'asc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $categories = $categories->where('name', 'like', '%'.$sort_search.'%');
        }
        $categories = $categories->paginate(15);
        return view('backend.product.extraprice.index', compact('categories', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /*  public function update(Request $request)
    {
		        $rules = array(
            'id' => 'required',
           'extra' => 'required'
           );
        $messages= array(
		
	);
        $this->validate(request(), $rules,$messages);
		 $user = Auth::user();
        $Extraprice = new Extraprice;
        $Extraprice->value = $request->extra;
        $Extraprice->category_id = $request->id;
        $Extraprice->created_by = $user->id;
        $Extraprice->save();

 $products=Product::where('category_id', $request->id)->get();
 foreach($products as $item){
	 $item->unit_price = $item->unit_price +($item->unit_price*$request->extra/100);
	 $item->save();
 }

       

        flash(translate('Brand Products Prices has been updated successfully'))->success();
        return redirect()->route('addprice.index');
    }
 */ 
 public function update(Request $request)
    {
		        $rules = array(
            'id' => 'required',
           'extra' => 'required'
           );
        $messages= array(
		
	);
        $this->validate(request(), $rules,$messages);
		 $user = Auth::user();
        $Extraprice = new Extraprice;
        $Extraprice->value = $request->extra;
        $Extraprice->item_id = $request->id;
        $Extraprice->created_by = $user->id;
        $Extraprice->save();

 $products=Product::where('brand_id', $request->id)->get();
 foreach($products as $item){
	$number = $item->unit_price +($item->unit_price*$request->extra/100);
	 $item->unit_price = number_format((float)round($number, 0), 2, '.', '');
	 $item->save();
 }

       

        flash(translate('Brand Products Prices has been updated successfully'))->success();
        return redirect()->route('addprice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
         $brand  = Brand::findOrFail($id);
     
        return view('backend.product.extraprice.edit', compact('brand','lang'));
    }

 

    
}
