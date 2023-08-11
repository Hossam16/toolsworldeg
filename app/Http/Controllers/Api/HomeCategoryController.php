<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\HomeCategoryCollection;
use App\Models\HomeCategory;
use Illuminate\Http\Request;
class HomeCategoryController extends Controller
{
    public function index()
    {
        return new HomeCategoryCollection(HomeCategory::all());
    }
}
