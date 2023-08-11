<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BrandCollection;
use App\Models\Brand;
use Illuminate\Http\Request;
class BrandController extends Controller
{
    public function index(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new BrandCollection(Brand::select('brand_translations.name as name1','brands.*')->join('brand_translations','brand_translations.brand_id','brands.id')->where('brand_translations.lang',$local)->get());
    }

    public function top(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new BrandCollection(Brand::select('brand_translations.name as name1','brands.*')->join('brand_translations','brand_translations.brand_id','brands.id')->where('brand_translations.lang',$local)->where('top', 1)->get());
    }
}
