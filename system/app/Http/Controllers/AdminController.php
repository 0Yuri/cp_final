<?php

namespace App\Http\Controllers;

use DB;

use App\User;
use App\Address;
use App\Ban;

class AdminController extends Controller
{

  public function __construct(){
    parent::__construct();
    $this->checkPermissionLevel();
  }

  public function pesquisarUsuario(){
    $data = $this->get_post();

    $usuarios = DB::table(User::TABLE_NAME)
    ->join(Address::TABLE_NAME, Address::TABLE_NAME . '.user_id', '=', User::TABLE_NAME . '.id')
    ->where('name', 'like', '%'.$data['name'].'%')
    ->get();

    if(count($usuarios) > 0){
      $this->return->setObject($usuarios);
    }
    else{
      $this->return->setFailed("Nenhum usuário foi encontrado.");
      return;
    }
  }

  public function banirUsuario(){
    $data = $this->get_post();

    $usuario = array(
      'banned_id' => $data['id'],
      'cpf' => $data['cpf'],
      'rg' => $data['rg'],
      'email'=> $data['email'],
      'reason' => 'testing'
    );

    $inserir = Ban::ban($usuario);

    if($inserir){
      return;
    }
    else{
      $this->return->setFailed("Ocorreu um erro ao banir o usuário.");
      return;
    }
  }

  public function desbanirUsuario(){
    $data = $this->get_post();

    $deletar = Ban::unban($data['id']);

    if($deletar){
      return;
    }
    else{
      $this->return->setFailed("Ocorreu um erro ao desbanir o usuário.");
      return;
    }
  }

  public function pesquisarLoja(){
    $data = $this->get_post();

    $loja = DB::table(Store::TABLE_NAME)
    ->join(User::TABLE_NAME, User::TABLE_NAME . '.id', '=', Store::TABLE_NAME . '.owner_id')
    ->select(User::TABLE_NAME . '.name as first_name', User::TABLE_NAME . '.last_name as last_name',
     User::TABLE_NAME . '.cpf', User::TABLE_NAME . '.email', Store::TABLE_NAME . 'stores.*')
    ->where(Store::TABLE_NAME . '.name', 'like', '%'.$data['name'].'%')
    ->get();

    if(count($loja) > 0){
      $this->return->setObject($loja);
      return;
    }
    else{
      $this->return->setFailed("Nenhuma loja foi encontrada.");
      return;
    }
  }

  public function toggleLoja(){
    $data = $this->get_post();

    $loja = DB::table(Store::TABLE_NAME)
    ->select('status')
    ->where('stores.id', $data['id'])
    ->get();

    if(count($loja) > 0){
      $loja = $loja[0];

      if($loja->status == 'ativado'){
        $atualizar = DB::table('stores')
        ->where('stores.id', $data['id'])
        ->update(['status' => 'desativado']);
      }
      else{
        $atualizar = DB::table('stores')
        ->where('stores.id', $data['id'])
        ->update(['status' => 'ativado']);
      }

      if($atualizar){
        return;
      }
      else{
        $this->return->setFailed("Não foi possível alterar o status da loja.");
        return;
      }
    }
    else{
      $this->return->setFailed("Nenhuma loja foi encontrada.");
      return;
    }
  }

  public function estatisticas(){
    $sedex = DB::table('pedidos')
    ->where('delivery_method', 'sedex')
    ->count();

    $pac = DB::table('pedidos')
    ->where('delivery_method', 'pac')
    ->count();

    $cartao = DB::table('pedidos')
    ->where('payment_method', 'cartao')
    ->count();

    $boleto = DB::table('pedidos')
    ->where('payment_method', 'boleto')
    ->count();

    $total = DB::table('pedidos')
    ->count();

    $retorno = array(
      'sedex' => $sedex,
      'pac' => $pac,
      'cartao' => $cartao,
      'boleto' => $boleto,
      'total' => $total
    );

    $this->return->setObject($retorno);

  }

  // Verifica se o usuario é administrador para realizar as operações deste controlador
  private function checkPermissionLevel(){
    if(isset($_SESSION['user_id'])){
      $usuario = DB::table(User::TABLE_NAME)
      ->where('id', $_SESSION['user_id'])
      ->where('account_type', 'admin')
      ->count();

      if($usuario > 0){
        return;
      }
      else{
        $this->return->setFailed("Você não tem permissão para executar esta função.");
        exit();
      }
    }
    else{
      $this->return->setFailed("Você não tem permissão para executar esta função.");
      exit();
    }
  }
}
