<?php

namespace App\Http\Controllers;

use DB;
use App\Marcas;

class BrandController extends Controller
{
  // Nova marca
  public function nova_marca(){
    $this->isLogged();

    $categoria = $this->get_post();

    $adicionou = Marcas::salvarMarca($categoria);

    if(!$adicionou){
      $this->return->setFailed("Erro ao adicionar nova marca.");
      return;
    }
  }

  public function ativar_marca(){
    $this->isLoggeed();
    $categoria = $this->get_post();

    $alterar = Marcas::ativarMarca($categoria['id']);

    if(!$alterar){
      $this->return->setFailed("Erro ao desativar uma marca.");
      return;
    }
  }

  public function desativar_marca(){
    $this->isLogged();
    $categoria = $this->get_post();

    $alterar = Marcas::desativarMarca($categoria['id']);

    if(!$alterar){
      $this->return->setFailed("Erro ao desativar uma marca.");
      return;
    }
  }

  // Pega todas as marcas existentes
  public function pegar_marcas(){
    $marcas = Marcas::pegarMarcas();

    if($marcas == null){
      $this->return->setFailed("Nenhuma marca foi encontrada.");
      return;
    }else{
      $this->return->setObject($marcas);
    }

  }


}
