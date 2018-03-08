<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Featured extends Model
{
  public static function produtosDestaque(){
    $produtos = DB::table('products')
    ->select('*')
    ->orderBy('sold', 'desc')
    ->where('status', 'ativado')
    ->get();

    return $produtos[0];
  }

  public static function lojasDestaque(){
    $lojas = DB::table('stores')
    ->select('*')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->orderBy('products.sold', 'desc')
    ->where('stores.status', 'ativado')
    ->get();

    return $lojas[0];
  }
}
