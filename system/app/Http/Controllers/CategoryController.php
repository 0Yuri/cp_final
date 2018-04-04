<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
  // Criar categoria
  public function newCategory(){
    $this->isLogged();
    $data = $this->get_post();
    $added = Category::saveCategory($data);

    if(!$added){
      $this->return->setFailed("Erro ao tentar adicionar nova categoria.");
      return;
    }
  }

  // Pega todas as categorias existentes e ativas
  public function getCategories(){
    $categories = Category::getCategories();

    if($categories == null){
      $this->return->setFailed("Nenhuma categoria foi encontrada.");
      return;
    }else{
      $this->return->setObject($categories);
    }
  }

}
