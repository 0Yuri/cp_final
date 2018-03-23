<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Store extends Model
{

  const TABLE_NAME = "stores";
  // Salva uma nova loja
  public static function saveStore($data){
    $added = DB::table(Store::TABLE_NAME)
    ->insert($data);

    if($added){
      return true;
    }
    else{
      return false;
    }
  }

  // Altera uma loja
  public static function updateStore($data, $id){
    $updated = DB::table(Store::TABLE_NAME)
    ->where('owner_id', $id)
    ->update($data);

    if($updated){
      return true;
    }
    else{
      return false;
    }
  }

  // Pega nome da loja pelo id do pedido
  public static function getNameStore($order_id){
    $order = DB::table('pedidos')
    ->select('store_id')
    ->where('pedidos.order_id', $order_id)
    ->get();

    if(count($order) > 0){
      $store_id = $order[0]->store_id;

      $store = DB::table(Store::TABLE_NAME)
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
  
  // Pega o id da loja pelo id do usuário
  public static function getStoreID($user_id){
    $loja = DB::table(Store::TABLE_NAME)
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

  // Muda a logo da loja
  public static function updateProfilePic($id, $address){
    $updated = DB::table(Store::TABLE_NAME)
    ->where('owner_id', $id)
    ->update(['profile_image' => $address]);

    if($updated){
      return true;
    }
    else{
      return false;
    }
  }

  // Ativa / Desativa uma loja
  public static function toggleStatusStore($id){
    $status_loja;

    $store = DB::table(Store::TABLE_NAME)
    ->select('status')
    ->where('owner_id', $id)
    ->get();

    if(count($store) > 0){
      $status_loja = (array)$store[0]->status;
    }else{
      return false;
    }

    if($status_loja[0] == 'ativado'){
      $status_loja = 'desativado';
    }else{
      $status_loja = 'ativado';
    }

    $updated = DB::table(Store::TABLE_NAME)
    ->where('owner_id', $id)
    ->update(['status' => $status_loja]);

    if($updated){
      return true;
    }else{
      return false;
    }

  }  

  // Verifica se o usuário tem uma loja.
  public static function storeExists($id){
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
  public static function statusStore($id){
    $store = DB::table(Store::TABLE_NAME)
    ->select('status')
    ->where('owner_id', $id)
    ->get();

    if(count($store) > 0){
      if($store[0]->status == 'ativado'){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  // Pega a loja do usuário logado - PAINEL
  public static function getLoggedStoreInfo($id){
    $fillable = ['id', 'name', 'description'];
    $store = DB::table(Store::TABLE_NAME)
    ->where('owner_id', $id)
    ->get();

    if(count($store) > 0){
      return $store[0];
    }
    else{
      return null;
    }
  }

  // Pega todas as lojas criadas e ativas
  public static function getStores(){
    $fillable = ['id', 'name', 'description', 'profile_image', 'unique_id'];

    $stores = DB::table(Store::TABLE_NAME)
    ->select($fillable)
    ->where('status', 'ativado')
    ->get();

    if(count($stores) > 0){
      return $stores;
    }else{
      return null;
    }
  }

  // Pega determinada loja para exibir sua página
  public static function getStore($unique_id){
    $store = DB::table(Store::TABLE_NAME)
    ->select('id', 'name', 'description', 'profile_image', 'banner_image')
    ->where('unique_id', '=', $unique_id)
    ->get();

    if(count($store) > 0){
      return (array)$store[0];
    }else{
      return null;
    }
  }

  public static function getStoreName($id){
    $store = DB::table(Store::TABLE_NAME)
    ->select('name')
    ->where('id', $id)
    ->get();

    if(count($store) > 0){
      return $store[0]->name;
    }
    else{
      return null;
    }
  }

  // Verifica se a loja pertence ao usuario logado
  public static function isMyStore($user_id, $store_id){
    $store = DB::table('stores')
    ->where('id', $store_id)
    ->where('owner_id', $user_id)
    ->get();

    if(count($store) > 0){
      return true;
    }
    else{
      return false;
    }
  }

}
