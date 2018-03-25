<?php

namespace App\Http\Controllers;

use App\Brand;

class BrandController extends Controller
{
  // Cria uma nova marca
  public function newBrand(){
    $this->isLogged();

    $categories = $this->get_post();

    $added = Brand::saveBrand($categories);

    if(!$added){
      $this->return->setFailed("Erro ao adicionar nova marca.");
      return;
    }
  }

  // Pega todas as marcas existentes e ativas
  public function getBrands(){
    $brands = Brand::getBrands();

    if($brands == null){
      $this->return->setFailed("Nenhuma marca foi encontrada.");
      return;
    }else{
      $this->return->setObject($brands);
    }

  }


}
