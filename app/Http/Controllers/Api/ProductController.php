<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\ProductDetailCollectionfav;
use App\Http\Resources\SearchProductCollection;
use App\Http\Resources\FlashDealCollection;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use App\Models\Wishlist;
class ProductController extends Controller
{
    public function index(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->get());
    }

  public function index2()
    {
        return new ProductCollection(Product::latest()->paginate(10));
    }

    public function show(Request $request,$id)
    {
		$local=$request->locale;
	
		if($local == ''){
			$local='eg';
		}
		$cnt=Wishlist::where(['product_id' => $id, 'user_id' => $request->user_id])->count();
		if($cnt>0){
		  return new ProductDetailCollectionfav(Product::select('product_translations.name as name1','product_translations.description as description1','product_translations.unit as unit1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('products.id', $id)->get());
  	
		}else{
		  return new ProductDetailCollection(Product::select('product_translations.name as name1','product_translations.description as description1','product_translations.unit as unit1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('products.id', $id)->get());
	
		}
            }

    public function admin(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('added_by', 'admin')->latest()->paginate(10));
    }

    public function seller(Request $request)
    {$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('added_by', 'seller')->latest()->paginate(10));
    }

    public function category(Request $request,$id)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->whereIn('category_id', $category_ids)->latest()->paginate(10));
    }

    public function subCategory(Request $request,$id)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->whereIn('category_id', $category_ids)->latest()->paginate(10));
    }

    public function subSubCategory(Request $request,$id)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->whereIn('category_id', $category_ids)->latest()->paginate(10));
    }

    public function brand(Request $request,$id)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('brand_id', $id)->latest()->paginate(10));
    }

    public function todaysDeal(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('todays_deal', 1)->latest()->get());
    }

    public function flashDeal()
    {
        $flash_deals = getFlashDeals()->where('status', 1)->where('featured', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
        return new FlashDealCollection($flash_deals);
    }

    public function featured(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('featured', 1)->latest()->get());
    }

    public function bestSeller(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->orderBy('num_of_sale', 'desc')->limit(20)->get());
    }

    public function related(Request $request,$id)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        $product = Product::find($id);
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('category_id', $product->category_id)->where('products.id', '!=', $id)->limit(10)->get());
    }

    public function topFromSeller(Request $request,$id)
    { $local=$request->locale;
		if($local == ''){
			$local='eg';
		}
        $product = Product::find($id);
        return new ProductCollection(Product::select('product_translations.name as name1','products.*')->join('product_translations','product_translations.product_id','products.id')->where('product_translations.lang',$local)->where('user_id', $product->user_id)->orderBy('num_of_sale', 'desc')->limit(4)->get());
    }

    public function search()
    {
        $key = request('key');
        $scope = request('scope');

        switch ($scope) {

            case 'price_low_to_high':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('unit_price', 'asc')->paginate(10));
                $collection->appends(['key' =>  $key, 'scope' => $scope]);
                return $collection;

            case 'price_high_to_low':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('unit_price', 'desc')->paginate(10));
                $collection->appends(['key' =>  $key, 'scope' => $scope]);
                return $collection;

            case 'new_arrival':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('created_at', 'desc')->paginate(10));
                $collection->appends(['key' =>  $key, 'scope' => $scope]);
                return $collection;

            case 'popularity':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('num_of_sale', 'desc')->paginate(10));
                $collection->appends(['key' =>  $key, 'scope' => $scope]);
                return $collection;

            case 'top_rated':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('rating', 'desc')->paginate(10));
                $collection->appends(['key' =>  $key, 'scope' => $scope]);
                return $collection;

            // case 'category':
            //
            //     $categories = Category::select('id')->where('name', 'like', "%{$key}%")->get()->toArray();
            //     $collection = new SearchProductCollection(Product::where('category_id', $categories)->orderBy('num_of_sale', 'desc')->paginate(10));
            //     $collection->appends(['key' =>  $key, 'scope' => $scope]);
            //     return $collection;
            //
            // case 'brand':
            //
            //     $brands = getBrands()->where('name', 'like', "%{$key}%")->all()->toArray();
            //     $collection = new SearchProductCollection(Product::where('brand_id', $brands)->orderBy('num_of_sale', 'desc')->paginate(10));
            //     $collection->appends(['key' =>  $key, 'scope' => $scope]);
            //     return $collection;
            //
            // case 'shop':
            //
            //     $shops = Shop::select('user_id')->where('name', 'like', "%{$key}%")->get()->toArray();
            //     $collection = new SearchProductCollection(Product::where('user_id', $shops)->orderBy('num_of_sale', 'desc')->paginate(10));
            //     $collection->appends(['key' =>  $key, 'scope' => $scope]);
            //     return $collection;

            default:
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('sku', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('num_of_sale', 'desc')->paginate(10));
                $collection->appends(['key' =>  $key, 'scope' => $scope]);
                return $collection;
        }
    }

    public function variantPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = '';
        $tax = 0;

        if ($request->has('color')) {
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode($request->choice) as $option) {
            $str .= $str != '' ?  '-'.str_replace(' ', '', $option->name) : str_replace(' ', '', $option->name);
        }

        if($str != null && $product->variant_product){
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $stockQuantity = $product_stock->qty;
        }
        else{
            $price = $product->unit_price;
            $stockQuantity = $product->current_stock;
        }

        //discount calculation
        $flash_deals = getFlashDeals()->where('status', 1)->all();
        $inFlashDeal = false;
        foreach ($flash_deals as $key => $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                if($flash_deal_product->discount_type == 'percent'){
                    $price -= ($price*$flash_deal_product->discount)/100;
                }
                elseif($flash_deal_product->discount_type == 'amount'){
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }
        if (!$inFlashDeal) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price*$product->tax) / 100;
        }
        elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        return response()->json([
            'product_id' => $product->id,
            'variant' => $str,
            'price' => (double) $price,
            'in_stock' => $stockQuantity < 1 ? false : true
        ]);
    }

    public function home()
    {
        return new ProductCollection(Product::inRandomOrder()->take(50)->get());
    }
	public function face_login()
    {
        return ['1'];
    }
}
