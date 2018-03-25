<?php

namespace App\Http\Controllers;

use App\Compras;
use App\Store;
use Moip\Moip;
use Moip\Auth\OAuth;
use App\MoipOrder;

class ShoppingController extends Controller
{

  public function getOrder(){
    $this->isLogged();
    $data = $this->get_post();
    $compra = Compras::get($_SESSION['user_id'], $data['id']);

    if($compra != null){
      $access_token = "a4face756e9e4e5c977b0b6449d4e168_v2";
      $moip = new Moip(new OAuth($access_token), Moip::ENDPOINT_SANDBOX);
      if($compra->type == 'single'){
        $pedido = MoipOrder::getSingleOrder($moip, $compra->order_id);
        if($pedido != null){
          $compra->loja = Store::getNameStore($compra->order_id);
          $compra->products = $pedido->getItemIterator();
          $compra->price = $pedido->getSubtotalItems()/100;
          $compra->frete = $pedido->getSubtotalShipping()/100;
          $compra->delivery_address = json_decode($compra->delivery_address);
          $this->return->setObject($compra);
        }
      }
      else{
        $pedidos = MoipOrder::getMultiOrder($moip, $compra->order_id);
        if($pedidos != null){
          $compra->pedidos = array();
          $compra->valorTotal = $pedidos->getAmountTotal()/100;
          foreach($pedidos->getOrderIterator() as $order){
            $order_id = $order->getId();
            $compra->pedidos[] = array(
              'id' => Compras::getUniqueIdOrder($order_id),
              'loja' => Store::getNameStore($order_id),
              'produtos' => $order->getItemIterator(),
              'frete' => $order->getSubtotalShipping()/100,
              'valor' => $order->getSubtotalItems()/100,
              'status' => $order->getStatus()
            );
          }
          $this->return->setObject($compra);
        }
        else{
          $this->return->setFailed("Ocorreu um erro ao consultar o seu multipedido.");
          return;
        }
      }
    }
    else{
      $this->return->setFailed("Nenhuma compra com este ID foi encontrada.");
      return;
    }

  }

  public function getAll(){
    $this->isLogged();
    $data = $this->get_post();
    $filtro = null;
    $pagina = 0;

    if(isset($data['filter'])){
      $filtro = $data['filter'];
    }

    if(isset($data['page'])){
      $pagina = $data['page'] - 1;
    }

    $compras = Compras::getAll($_SESSION['user_id'], $filtro, $pagina);
    // $compras = Shopping::getAll($_SESSION['user_id'], $filtro, $pagina);

    if($compras != null){
      $this->return->setObject($compras);
    }
    else{
      $this->return->setFailed("Nenhuma compra encontrada.");
      return;
    }
  }


}
