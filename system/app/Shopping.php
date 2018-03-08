<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Shopping extends Model
{
  public static function pegarPedidos($id, $filters, $page=0){
    $condicoes = array();
    $condicoes[] = ['buyer_id', '=', $id];
    $filtros = ['CREATED','WAITING','IN_ANALYSIS','PRE_AUTHORIZED','AUTHORIZED','CANCELLED', 'REFUNDED', 'REVERSED', 'SETTLED', 'PAID'];

    if(isset($filters['filter']) && strlen($filters['filter']) > 0){
      switch($filters['filter']){
        case "PROGRESS":
          $filtros = ['IN_ANALYSIS','PRE_AUTHORIZED','AUTHORIZED','PAID'];
          break;
        case "CANCELLED":
          $filtros = ['CANCELLED'];
          break;
        case "DONE":
          $filtros = ['FINISHED','REFUNDED','SETTLED'];
          break;
        default:
          $filtros = ['CREATED','WAITING','IN_ANALYSIS','PRE_AUTHORIZED','AUTHORIZED','CANCELLED', 'REFUNDED', 'REVERSED', 'SETTLED', 'PAID'];
          break;
      }
    }

    $pedidos = DB::table('orders')
    ->select('*')
    ->orderBy('created_at', 'desc')
    ->skip($page * 8)
    ->take(8)
    ->where($condicoes)
    ->whereIn('status', $filtros)
    ->get();

    $qtd_pedidos = DB::table('orders')
    ->select('*')
    ->where($condicoes)
    ->whereIn('status', $filtros)
    ->count();

    if($qtd_pedidos < 8){
      $paginas = 1;
    }
    else{
      $resto = $qtd_pedidos%8;
      $paginas = ($qtd_pedidos - $resto)/8;

      if($resto > 0){
        $paginas++;
      }
    }

    return array(
      'paginas' => $paginas,
      'pedidos' => $pedidos
    );
  }

  public static function pegarCompra($user_id, $order_id){
    $condicoes = array(['buyer_id', '=', $user_id], ['unique_id', '=', $order_id]);

    $pedido = DB::table('orders')
    ->select('*')
    ->where($condicoes)
    ->get();


    if(count($pedido) > 0){
      return (array)$pedido[0];
    }
    else{
      return null;
    }
  }

}
