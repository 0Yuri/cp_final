<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\Product;
use App\Store;
use App\Category;

class Featured extends Model
{

  public static function featuredProducts(){
    $products = DB::table(Product::TABLE_NAME)
    ->join('product_images', 'product_images.product_id', '=', Product::TABLE_NAME . '.id')
    ->join(Category::TABLE_NAME, Category::TABLE_NAME . '.id', '=', Product::TABLE_NAME . '.category_id')
    ->select(Product::TABLE_NAME . '.*', 'product_images.filename', Category::TABLE_NAME . '.name as categoria')
    ->take(8)
    ->orderBy('solds', 'asc')
    ->where('product_images.type', 'profile')
    ->get();

    if(count($products) > 0){
      return $products;
    }
    else{
      return array();
    }

    return $produtos[0];
  }

  public static function featuredStores(){
    $stores = DB::table(Store::TABLE_NAME)
    ->select('*')
    ->take(8)
    ->orderBy('sales', 'asc')
    ->get();

    if(count($stores) > 0){
      foreach($stores as $store){
        $store->n_produtos = Featured::numberOfProduct($store->id);
      }
      return $stores;
    }
    else{
      return array();
    }
  }

  public static function numberOfProduct($product_id){
    $product = DB::table(Product::TABLE_NAME)
    ->where("status", "ativado")
    ->where("store_id", $product_id)
    ->count();

    return $product;
  }
}
