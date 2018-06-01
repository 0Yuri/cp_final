<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\Product;
use App\Store;
use App\Category;

class Featured extends Model
{

  public static function featuredProducts($take=4){
    $products = DB::table(Product::TABLE_NAME)
    ->join('product_images', 'product_images.product_id', '=', Product::TABLE_NAME . '.id')
    ->join(Category::TABLE_NAME, Category::TABLE_NAME . '.id', '=', Product::TABLE_NAME . '.category_id')
    ->join(Brand::TABLE_NAME, Brand::TABLE_NAME . '.id', '=', Product::TABLE_NAME . '.brand_id')
    ->select(Product::TABLE_NAME . '.unique_id', Product::TABLE_NAME . '.name', Product::TABLE_NAME . '.price', Product::TABLE_NAME . '.solds as vendidos','product_images.filename', Category::TABLE_NAME . '.name as category', Brand::TABLE_NAME . '.name as brand')
    ->take($take)
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

  public static function featuredStores($take=4){
    $stores = DB::table(Store::TABLE_NAME)
    ->select('*')
    ->take($take)
    ->get();

    if(count($stores) > 0){
      foreach($stores as $store){
        $store->n_produtos = Featured::numberOfProduct($store->id);
        $store->sales = Featured::numberOfSales($store->id);
      }
      return $stores;
    }
    else{
      return array();
    }
  }

  public static function numberOfSales($store_id){
    $vendas = DB::table(Product::TABLE_NAME)
    ->where("store_id", $store_id)
    ->sum('solds');

    return $vendas;
  }

  public static function numberOfProduct($store_id){
    $product = DB::table(Product::TABLE_NAME)
    ->where("status", "ativado")
    ->where("store_id", $store_id)
    ->count();

    return $product;
  }
}
