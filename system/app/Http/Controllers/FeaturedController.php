<?php

namespace App\Http\Controllers;

use DB;

use App\Featured;

class FeaturedController extends Controller
{
  public function featuredStores(){

    $lojas = Featured::featuredStores();

    if(count($lojas) > 0){
      $this->return->setObject($lojas);
    }
    else{
      $this->return->setFailed("Nenhuma loja encontrada.");
      return;
    }
  }

  public function featuredProducts(){
    $produtos = Featured::featuredProducts();

    if(count($produtos) > 0){
      $this->return->setObject($produtos);
    }
    else{
      $this->return->setFailed("Nenhum produto encontrado.");
      return;
    }
  }
}
