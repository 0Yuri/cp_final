<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Sales extends Model
{

    public static function getOrder($order_id, $store_id){
        $order = DB::table('pedidos')
        ->where('pedidos.store_id', $store_id)
        ->where('pedidos.unique_id', $order_id)
        ->get();

        if(count($order) > 0){
            return $order[0];
        }
        else{
            return null;
        }

    }

    public static function getAll($id, $filtros, $page = 1){
        $status = $condicoes = array();
        $condicoes[] = ['store_id', '=', $id];

        $page -= 1;

        if($filtros != null){
            switch($filtros){
                case "PROGRESS":
                    $status[] = ['Aguardando pagamento'];
                    break;
                case "DONE":
                    $status[] = ['Pago', 'Reembolsado'];
                    break;
                case "CANCELLED":
                    $status[] = ['Cancelado'];
                    break;
            }
        }

        if(sizeof($status) == 0){
            $pedidos = DB::table('pedidos')
            ->select('pedidos.unique_id', 'pedidos.status', 'pedidos.id', 'pedidos.created_at')
            ->where($condicoes)
            ->get();
        }
        else{
            $pedidos = DB::table('pedidos')
            ->select('pedidos.unique_id', 'pedidos.status', 'pedidos.id', 'pedidos.created_at')
            ->where($condicoes)
            ->whereIn('status', $status)
            ->get();
        }        

        if(count($pedidos) > 0){
            return array(
                'vendas' => $pedidos,
                'paginas' => 1
            );
        }
        else{
            return array(
                'vendas' => array(),
                'paginas' => 1
            );
        }
    }
}
