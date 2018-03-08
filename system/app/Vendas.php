<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Vendas extends Model
{

  public static function get($unique_id, $store_id){
    $condicoes = array(['store_id', $store_id], ['unique_id', $unique_id]);

    $venda = DB::table('pedidos')
    ->select('*')
    ->where($condicoes)
    ->get();

    if(count($venda) > 0){
      return $venda[0];
    }
    else{
      return null;
    }
  }

  public static function getAll($store_id, $status, $pagina = 0){
    $condicoes = array(
      ['store_id', $store_id],
      ['order_id', 'like', 'ORD%']
    );

    switch($status){
      case 'PROGRESS':
        $filtros = ['Aguardando pagamento'];
        break;
      case 'DONE':
        $filtros = ['Pago','Reembolsado'];
        break;
      case 'CANCELLED':
        $filtros = ['Cancelado'];
        break;
      default:
        $filtros = ['Aguardando pagamento','Pago','Cancelado','Reembolsado'];
        break;
    }

    $vendas = DB::table('pedidos')
    ->select('*')
    ->where($condicoes)
    ->skip($pagina * 8)->take(8)
    ->whereIn('status', $filtros)
    ->get();

    if(count($vendas) > 0){
      return array(
        'paginas' => Vendas::getNumberOf($store_id, $filtros),
        'vendas' => $vendas
      );
    }
    else{
      return array(
        'paginas' => 1,
        'vendas' => null
      );
    }
  }

  public static function getNumberOf($store_id, $status){
    $vendas = DB::table('pedidos')
    ->where('store_id', $store_id)
    ->where('order_id', 'like', 'ORD%')
    ->whereIn('status', $status)
    ->count();

    if($vendas < 8){
      return 1;
    }
    else{
      $resto = $vendas%8;
      $qtd_paginas = (($vendas - $resto)/8);
      if($resto > 0){
        $qtd_paginas++;
      }
    }

    return $qtd_paginas;
  }

}
