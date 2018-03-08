<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Store extends Model
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

  public static function getNameStore($order_id){
    $order = DB::table('pedidos')
    ->select('store_id')
    ->where('pedidos.order_id', $order_id)
    ->get();


    if(count($order) > 0){
      $store_id = $order[0]->store_id;

      $store = DB::table('stores')
      ->select('name')
      ->where('id', $store_id)
      ->get();

      if(count($store) > 0){
        return $store[0]->name;
      }
      else{
        return null;
      }
    }
    else{
      return null;
    }
  }

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

  // Desativa / Ativa uma loja
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

  // Altera uma loja
  public static function alterarLoja($data, $id){
    if(isset($_SESSION['new_pic']) && strlen($_SESSION['new_pic'] > 0)){
      $data['profile_image'] = $_SESSION['new_pic'];
    }

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

  // Verifica se existe uma loja com o dono sendo o usuário logado.
  public static function existeLoja($id){
    $loja = DB::table('stores')
    ->select('*')
    ->where('owner_id', $id)
    ->get();

    if(count($loja) > 0){
      return true;
    }
    else{
      return false;
    }
  }

  // Verifica se a loja do usuário logado está ativada.
  public static function statusLoja($id){
    $loja = DB::table('stores')
    ->select('status')
    ->where('owner_id', $id)
    ->get();

    if(count($loja) > 0){
      if($loja[0]->status == 'ativado'){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  // Pega a loja do usuário logado - PAINEL
  public static function pegarLojaLogado($id){
    $fillable = ['id', 'name', 'description'];
    $loja = DB::table('stores')
    ->where('owner_id', $id)
    ->get();

    if(count($loja) > 0){
      return $loja[0];
    }
    else{
      return null;
    }
  }

  // Pega todas as lojas criadas e ativas
  public static function pegarTodasLojas(){
    $lojas = DB::table('stores')
    ->select('id', 'name', 'description', 'profile_image')
    ->where('status', 'ativado')
    ->get();

    if(count($lojas) > 0){
      return $lojas;
    }else{
      return null;
    }
  }

  // Pega determinada loja para exibir sua página
  public static function pegarLoja($name){
    $loja = DB::table('stores')
    ->select('id', 'name', 'description', 'profile_image', 'banner_image')
    ->where('name', '=', $name)
    ->get();

    if(count($loja) > 0){
      return (array)$loja[0];
    }else{
      return null;
    }
  }

  public static function pegarNomeLoja($id){
    $loja = DB::table('stores')
    ->select('name')
    ->where('id', $id)
    ->get();

    if(count($loja) < 0){
      return null;
    }
    else{
      return $loja[0]->name;
    }
  }

}
