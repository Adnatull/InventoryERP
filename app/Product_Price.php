<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Price extends Model
{
  public function Product() {
      return $this->belongsTo('App\Product', 'product_id', 'id');
  }
}
