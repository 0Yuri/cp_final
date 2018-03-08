<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Moip\Moip;

class Order extends Model
{
  // Pegar o pedido
  public static function pegarPedido($unique_id){
    $pedido = DB::table('orders')
    ->select('*')
    ->where('unique_id', $unique_id)
    ->get();

    if(count($pedido) > 0){
      return (array)$pedido[0];
    }
    else{
      return null;
    }
  }
  // Verifica se o pedido é válido - Se o Carrinho está vazio
  public static function verificarPedido($pedidos){
    $i = 0;

    foreach($pedidos as $pedido){
      foreach($pedido['produtos'] as $produto){
        $i += $produto['quantidade'];
      }
    }

    if($i > 0){
      return true;
    }
    else{
      return false;
    }
  }
  // Salvar o pedido
  public static function salvarPedido($buyer_id, $store_id, $order_id, $payment_method, $delivery_method, $delivery_address, $multi_id=null){
    
    $pedido = array(
      'buyer_id' => $buyer_id,
      'unique_id' => uniqid("CP-ORD"),
      'order_id' => $order_id,
      'store_id' => $store_id,
      'payment_method' => $payment_method,
      'delivery_method' => $delivery_method,
      'delivery_address' => json_encode($delivery_address),
      'multiorder_id' => $multi_id
    );

    $inseriu = DB::table('pedidos')
    ->insert($pedido);

    if($inseriu){
      return true;
    }
    else{
      return false;
    }
  }


}
