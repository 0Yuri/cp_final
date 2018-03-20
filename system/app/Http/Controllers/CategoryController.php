<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
  // Criar categoria
  public function novaCategoria(){
    $this->isLogged();
    $data = $this->get_post();
    $adicionou = Category::saveCategory($data);

    if($adicionou){
      return;
    }else{
      $this->return->setFailed("Erro ao tentar adicionar nova categoria.");
      exit();
    }
  }

  // Listar categorias
  public function pegar_categorias(){
    $categorias = Category::getCategories();
    if($categorias == null){
      $this->return->setFailed("Nenhuma categoria foi encontrada.");
      exit();
    }else{
      $this->return->setObject($categorias);
    }
  }

}
