<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MyOrders extends Model
{

  // Pega pedido de acordo com seu identificador(ID)
  public static function pegarPedidoX($id){
    $pedido = DB::table('orders')->select('*')
    ->where('unique_id', $id)
    ->get();

    if(count($pedido) > 0){
      return $pedido[0];
    }
    else{
      return null;
    }
  }

  // Pegar todos os pedidos em que o usuário foi o comprador
  public static function pegarPedidos($id){
    $pedidos = DB::table('orders')
    ->select('*')
    // ->skip(2)
    // ->take(6)
    ->where('buyer_id', $id)
    ->get();

    if(count($pedidos) > 0){
      return $pedidos;
    }
    else{
      return null;
    }
  }

  // Pegar todos os pedidos em que o usuário foi o vendedor
  public static function pegarVendas($id, $status=null){
    $condicoes = array();
    $condicoes[] = ['user_id','=', $id];

    if($status != null){
      switch($status){
        case 'OPEN':
          $status = ['CREATED', 'WAITING', 'IN ANALYSIS'];
          break;
        case 'DONE':
          $status = ['PAID'];
          break;
        case 'CANCELLED':
          $status = ['CANCELLED'];
          break;
      }

      $vendas = DB::table('moip_accounts')
      ->select('orders.*')
      ->join('orders', 'orders.seller_id', 'moip_accounts.account_id')
      ->where($condicoes)
      ->whereIn('status', $status)
      ->get();
    }
    else{
      $vendas = DB::table('moip_accounts')
      ->select('orders.*')
      ->join('orders', 'orders.seller_id', 'moip_accounts.account_id')
      ->where($condicoes)
      ->get();
    }



    if(count($vendas) > 0){
      return $vendas;
    }
    else{
      return null;
    }
  }

  public static function getLogistics($carrinho, $id){
    $logistica = array(
      'peso' => 0.0,
      'altura' => 0.0,
      'largura' => 0.0,
      'comprimento' => 0.0,
      'valor_declarado' => 0.0
    );

    if(count($carrinho) > 0){
      foreach($carrinho as $key => $produto){
        $produto = DB::table('products')
        ->select('height as altura', 'length as comprimento', 'weight as peso', 'width as largura', 'price as preco')
        ->where('id', $key)
        ->get();

        if(count($produto) > 0){
          $produto = $produto[0];
          $logistica['peso'] += ($produto->peso/1000);
          $logistica['altura'] += ($produto->altura);
          $logistica['largura'] += ($produto->largura);
          $logistica['comprimento'] += ($produto->comprimento);
          $logistica['valor_declarado'] += round($produto->preco);
          print_r($logistica);
        }
      }

      return $logistica;
    }
    else{
      return $logistica;
    }
  }

}
