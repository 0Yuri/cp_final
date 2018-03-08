<?php

namespace App\Http\Controllers;

use DB;

class FeaturedController extends Controller
{
  public function lojasDestaque(){

    $lojas = DB::table('stores')
    ->select('*')
    ->take(8)
    ->orderBy('sales', 'asc')
    ->get();

    if(count($lojas) > 0){
      foreach($lojas as $loja){
        $loja->n_produtos = $this->produtos($loja->id);
      }
      $this->return->setObject($lojas);
      return;
    }
    else{
      $this->return->setFailed("Nenhuma loja encontrada.");
      return;
    }
  }

  private function produtos($id){
    $produtos = DB::table('products')
    ->where('status', 'ativado')
    ->where('store_id', $id)
    ->count();

    return $produtos;
  }

  public function produtosDestaque(){

    $produtos = DB::table('products')
    ->join('product_images', 'product_images.product_id', '=', 'products.id')
    ->join('categories', 'categories.id', '=', 'products.category_id')
    ->select('products.*', 'product_images.filename', 'categories.name as categoria')
    ->take(8)
    ->orderBy('solds', 'asc')
    ->where('product_images.type', 'profile')
    ->get();

    if(count($produtos) > 0){
      $this->return->setObject($produtos);
    }
    else{
      $this->return->setFailed("Nenhum produto encontrado.");
      return;
    }
  }
}
