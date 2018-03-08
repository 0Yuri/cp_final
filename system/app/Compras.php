<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Compras extends Model
{

  public static function getAll($user_id, $filters=null, $page=0){
    if($filters != null){
      switch($filters){
        case 'PROGRESS':
          $filtros = ['Aguardando pagamento'];
          break;
        case 'CANCELLED':
          $filtros = ['Cancelado'];
          break;
        case 'DONE':
          $filtros = ['Pago', 'Reembolsado'];
          break;
        default:
          $filtros = ['Aguardando pagamento', 'Pago', 'Cancelado', 'Reembolsado'];
          break;
      }
    }
    else{
      $filtros = ['Aguardando pagamento', 'Pago', 'Cancelado', 'Reembolsado'];
    }

    $compras = DB::table('pedidos')
    ->select('created_at', 'unique_id', 'status')
    ->where('buyer_id', $user_id)
    ->where('order_id', 'like', 'ORD%')
    ->whereIn('status', $filtros)
    ->skip($page * 8)
    ->take(8)
    ->get();

    if(count($compras) > 0){
      return array(
        'paginas' => Compras::numberOfPages($filtros, $user_id),
        'compras' => $compras
      );
    }
    else{
      return array(
        'paginas' => 1,
        'compras' => null
      );
    }
  }

  public static function numberOfPages($filters, $user_id){
    $compras = DB::table('pedidos')
    ->where('buyer_id', $user_id)
    ->where('order_id', 'like', 'ORD%')
    ->whereIn('status', $filters)
    ->count();

    $resto = $compras%8;

    $qtd = ($compras - $resto)/8;

    if($resto > 0){
      $qtd++;
    }

    return $qtd;
  }

  public static function getUniqueId($order_id){
    $id = DB::table('pedidos')
    ->select('unique_id')
    ->where('pedidos.order_id', $order_id)
    ->get();

    if(count($id) > 0){
      return $id[0]->unique_id;
    }
    else{
      return null;
    }
  }

  public static function get($user_id, $unique_id){
    $condicoes = array(
      ['buyer_id', '=', $user_id],
      ['unique_id', '=', $unique_id]
    );

    $pedido = DB::table('pedidos')
    ->where($condicoes)
    ->get();

    if(count($pedido) > 0){
      $pedido = $pedido[0];
      if(Compras::isMultiPedido($pedido->order_id)){
        $pedido->type="multi";
      }
      else{
        $pedido->type="single";
        $pedido->multiorder_id = Compras::getUniqueIDMulti($pedido->multiorder_id);
      }
      return $pedido;
    }
    else{
      return null;
    }
  }

  public static function getUniqueIdOrder($order_id){
    $unique_id = DB::table('pedidos')
    ->select('unique_id')
    ->where('order_id', $order_id)
    ->get();

    if(count($unique_id) > 0){
      return $unique_id[0]->unique_id;
    }
    else{
      return null;
    }
  }

  public static function getUniqueIDMulti($multiorder_id){
    $id = DB::table('pedidos')
    ->select('unique_id')
    ->where('order_id', $multiorder_id)
    ->get();

    if(count($id) > 0){
      return $id[0]->unique_id;
    }
    else{
      return null;
    }
  }

  public static function isMultiPedido($unique_id){
    if(substr($unique_id,0,3) == 'MOR'){
      return true;
    }
    else{
      return false;
    }
  }
}
