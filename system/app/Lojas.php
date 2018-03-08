<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Lojas extends Model
{
  // Salva uma nova loja
  public static function salvarLoja($data){
    $adicionou = DB::table('stores')
    ->insert($data);

    if($adicionou > 0){
      return true;
    }
    else{
      return false;
    }
  }

  // Pega o nome da loja através do pedido
  public static function getNameStore($order_id){
    $loja = DB::table('pedidos')
    ->join('stores', 'stores.id', '=', 'pedidos.store_id')
    ->select('stores.name')
    ->where('pedidos.order_id', $order_id)
    ->get();

    if(count($loja) > 0){
      return $loja[0]->name;
    }
    else{
      return null;
    }
  }

  // Pega o ID da loja
  public static function getStoreID($user_id){
    $loja = DB::table('stores')
    ->select('id')
    ->where('stores.owner_id', $user_id)
    ->get();

    if(count($loja) > 0){
      return $loja[0]->id;
    }
    else{
      return null;
    }
  }

  // Verifica se a loja pertence ao usuario logado
  public static function IsMyLoja($user_id, $store_id){
    $loja = DB::table('stores')
    ->where('id', $store_id)
    ->where('owner_id', $user_id)
    ->get();

    if(count($loja) > 0){
      return true;
    }
    else{
      return false;
    }
  }

  // Muda a foto de perfil da loja
  public static function mudarProfile($id, $address){
    $consulta = DB::table('stores')
    ->where('owner_id', $id)
    ->update(['profile_image' => $address]);

    if($consulta){
      return true;
    }
    else{
      return false;
    }
  }

  // Alterna o status da loja
  public static function mudarStatusLoja($id){
    $status_loja;

    $loja = DB::table('stores')
    ->select('status')
    ->where('owner_id', $id)
    ->get();

    if(count($loja) > 0){
      $status_loja = (array)$loja[0]->status;
    }else{
      return false;
    }

    if($status_loja[0] == 'ativado'){
      $status_loja = 'desativado';
    }else{
      $status_loja = 'ativado';
    }

    $alterar = DB::table('stores')
    ->where('owner_id', $id)
    ->update(['status' => $status_loja]);

    if($alterar){
      return true;
    }else{
      return false;
    }

  }

  // Altera uma loja - update
  public static function alterarLoja($data, $id){

    $alterar = DB::table('stores')
    ->where('owner_id', $id)
    ->update($data);

    if($alterar){
      return true;
    }
    else{
      return false;
    }
  }

  // Verifica se o usuario tem uma loja criada
  public static function existeLoja($user_id){
    $loja = DB::table('stores')
    ->select('*')
    ->where('owner_id', $user_id)
    ->get();

    if(count($loja) > 0){
      return true;
    }
    else{
      return false;
    }
  }

  // Status da loja (ATIVADO => TRUE || DESATIVADA => FALSE)
  public static function statusLoja($user_id){
    $loja = DB::table('stores')
    ->select('status')
    ->where('owner_id', $user_id)
    ->get();

    if(count($loja) > 0){
      if($loja[0]->status == 'ativado'){
        return true;
      }
      else{
        return false;
      }
    }
    else{
      return false;
    }
  }

  // Ver Loja
  public static function pegarLoja($unique_id){
    $loja = DB::table('stores')
    ->select('id', 'unique_id', 'name', 'description', 'profile_image', 'banner_image')
    ->where('unique_id', '=', $unique_id)
    ->get();

    if(count($loja) > 0){
      return (array)$loja[0];
    }
    else{
      return null;
    }
  }

  // Ver Lojas
  public static function pegarTodasLojas(){

    $lojas = DB::table('stores')
    ->select('unique_id', 'name', 'profile_image')
    ->where('status', 'ativado')
    ->get();

    if(count($lojas) > 0){
      return $lojas;
    }
    else{
      return null;
    }

  }

  // Pegar Loja do usuario logado
  public static function pegarLojaLogado($user_id){
    $loja = DB::table('stores')
    ->where('owner_id', $user_id)
    ->get();

    if(count($loja) > 0){
      return $loja[0];
    }
    else{
      return null;
    }
  }

  // Pega o nome de uma loja pelo ID
  public static function pegaNomeLoja($store_id){
    $loja = DB::table('stores')
    ->select('name')
    ->where('id', $store_id)
    ->get();

    if(count($loja) > 0 ){
      return $loja[0]->name;
    }
    else{
      return null;
    }
  }
}
