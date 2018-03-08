<?php

namespace App\Http\Controllers;

use App\Categorias;

class CategoryController extends Controller
{
  // Criar categoria
  public function nova_categoria(){
    $this->isLogged();
    $data = $this->get_post();
    $adicionou = Categorias::salvarCategoria($data);

    if($adicionou){
      return;
    }else{
      $this->return->setFailed("Erro ao tentar adicionar nova categoria.");
      exit();
    }
  }

  // Listar categorias
  public function pegar_categorias(){
    $categorias = Categorias::pegarCategorias();
    if($categorias == null){
      $this->return->setFailed("Nenhuma categoria foi encontrada.");
      exit();
    }else{
      $this->return->setObject($categorias);
    }
  }

}
