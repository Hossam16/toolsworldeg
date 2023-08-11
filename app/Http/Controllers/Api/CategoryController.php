<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryCollection;
use App\Models\BusinessSetting;
use App\Models\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{

    public function index(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new CategoryCollection(Category::select('category_translations.name as name1','categories.*')->join('category_translations','category_translations.category_id','categories.id')->where('category_translations.lang',$local)->where('level', 0)->get());
    }

    public function featured(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        return new CategoryCollection(Category::select('category_translations.name as name1','categories.*')->join('category_translations','category_translations.category_id','categories.id')->where('category_translations.lang',$local)->where('featured', 1)->get());
    }

    public function home(Request $request)
    {
		$local=$request->locale;
		
		if($local == ''){
			$local='eg';
		}
        $homepageCategories = getBusinessSetting()->where('type', 'home_categories')->first();
        $homepageCategories = json_decode($homepageCategories->value);
        return new CategoryCollection(Category::whereIn('id', $homepageCategories)->get());
    }
}
