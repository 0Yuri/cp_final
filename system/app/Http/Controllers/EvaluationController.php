<?php

namespace App\Http\Controllers;

use App\Evaluation;
use App\User;
use DB;

class EvaluationController extends Controller
{
  public function isSellerEvaluated(){
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

  public function isBuyerEvaluated(){
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

  public function evaluateBuyer(){
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

  public function evaluateSeller(){
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

  public function getMyEvaluations(){
    $this->isLogged();

    $consulta = DB::table(Evaluation::TABLE_NAME)
    ->join(User::TABLE_NAME, User::TABLE_NAME . '.id', '=', Evaluation::TABLE_NAME . '.evaluator_id')
    ->select(Evaluation::TABLE_NAME . '.rate', Evaluation::TABLE_NAME . '.evaluator_id', User::TABLE_NAME . '.name', User::TABLE_NAME . '.last_name')
    ->where(Evaluation::TABLE_NAME . '.evaluated_id', $_SESSION['user_id'])
    ->get();

    if(count($consulta) > 0){
      $this->return->setObject($consulta);
    }
    else{
      $this->return->setFailed("Nenhuma avaliação foi encontrada.");
      return;
    }
  }
}
