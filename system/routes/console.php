<?php

use Illuminate\Foundation\Inspiring;

use App\Order;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('pedidos', function(){
    // $multipedidos = DB::table(Order::TABLE_NAME)
    // ->select('*')
    // ->where('order_id', 'like', 'MOR-%')
    // ->whereNotNull('multiorder_id')
    // ->get();

    // if(count($multipedidos) > 0){
    //   foreach($multipedidos as $pedido){
    //   }
    // }

    $pedidos = DB::table(Order::TABLE_NAME)
    ->select('*')
    ->where('order_id', 'like', 'ORD-%')
    ->whereNull('multiorder_id')
    ->get();

    if(count($pedidos) > 0){
      foreach($pedidos as $pedido){
        Order::atualizarPedido($pedido);
      }
    }
})->describe('Atualizando pedido');