<?php

namespace App\Http\Controllers;

use App\Brand;

class BrandController extends Controller
{
  // Nova marca
  public function nova_marca(){
    $this->isLogged();

    $categoria = $this->get_post();

    $adicionou = Brand::saveBrand($categoria);

    if(!$adicionou){
      $this->return->setFailed("Erro ao adicionar nova marca.");
      return;
    }
  }

  // Pega todas as marcas existentes
  public function pegar_marcas(){
    $marcas = Brand::getBrands();

    if($marcas == null){
      $this->return->setFailed("Nenhuma marca foi encontrada.");
      return;
    }else{
      $this->return->setObject($marcas);
    }

  }


}
