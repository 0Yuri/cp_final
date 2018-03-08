<?php

namespace App\Http\Controllers;

use App\Evaluation;
use DB;

class EvaluationController extends Controller
{
  public function vendedorAvaliado(){
    $this->isLogged();
    $data = $this->get_post();

    $avaliacao = DB::table('evaluations')
    ->select('*')
    ->where('order_id', $data['id'])
    ->where('evaluator_id', $_SESSION['user_id'])
    ->get();

    if(count($avaliacao) > 0){
      $this->return->setObject($avaliacao[0]);
      return;
    }
    else{
      $this->return->setFailed("O comprador não foi avaliado.");
      return;
    }

  }

  public function compradorAvaliado(){
    $this->isLogged();
    $data = $this->get_post();

    $avaliacao = DB::table('evaluations')
    ->select('*')
    ->where('order_id' , $data['id'])
    ->where('evaluated_id', $_SESSION['user_id'])
    ->get();

    if(count($avaliacao) > 0){
      $this->return->setObject($avaliacao[0]);
      return;
    }
    else{
      $this->return->setFailed("O comprador não foi avaliado.");
      return;
    }


  }

  public function avaliarComprador(){
    $this->isLogged();
    $data = $this->get_post();

    $usuario = DB::table('pedidos')
    ->join('users', 'users.id', '=', 'pedidos.buyer_id')
    ->select('users.id')
    ->where('pedidos.unique_id', '=', $data['pedido'])
    ->get();

    if(count($usuario) > 0){
      $usuario = $usuario[0];

      $inserir = Evaluation::salvarAvaliacao($_SESSION['user_id'], $usuario->id, $data['avaliacao']->rate, $data['pedido']);
    }
  }

  public function avaliarVendedor(){
    $this->isLogged();
    $data = $this->get_post();

    $usuario = DB::table('pedidos')
    ->join('users','users.id', '=', 'pedidos.store_id')
    ->select('users.id')
    ->where('pedidos.unique_id', $data['pedido'])
    ->get();

    if(count($usuario) > 0){
      $usuario = $usuario[0];

      $inserir = Evaluation::salvarAvaliacao($_SESSION['user_id'], $usuario->id, $data['avaliacao']->rate, $data['pedido']);

      if(!$inserir){
        $this->return->setFailed("Ocorreu um erro na hora de avaliar.");
        return;
      }
    }
    else{
      $this->return->setFailed("Nenhuma loja foi encontrada para ser avaliada.");
      return;
    }
  }
}
