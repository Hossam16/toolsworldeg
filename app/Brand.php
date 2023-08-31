<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Brand extends Model
{
  public function getTranslation($field = '', $lang = false){
    $brand_translation = trans("Brand." . $this->id);
    return $brand_translation;
  }

  public function brand_translations(){
    return $this->hasMany(BrandTranslation::class);
  }

}
