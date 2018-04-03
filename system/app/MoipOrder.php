<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Moip\Moip;
use Moip\Auth\OAuth;
use DB;

use App\Order;


class MoipOrder extends Model
{
  // Conta do moip
  const ACCOUNT_ID = "MPA-B4ABF9C3ED72";
  // Taxas Vendedor e Crespass
  const SELLER_AMOUNT = 80;
  const CP_AMOUNT = 20;

  // CRIAR TIPOS DE PEDIDOS

  public static function criarPedidoSimples(Moip $moip, $pedido, $customer, $payment_method){
    $discount = 0;
    try{
      $order = $moip->orders()->setOwnId(uniqid());

      foreach($pedido['produtos'] as $produto){
        $valor = MoipOrder::getPrice($produto['preco']);
        $discount += MoipOrder::getDiscount($produto['preco'], $produto['desconto']);
        $order->addItem($produto['nome'], $produto['quantidade'], "Descricao teste", $valor);
        Product::increaseSolds($produto['id'], $produto['quantidade']);
        Product::lowerStock($produto['id'], $produto['quantidade']);
      }

      $frete = 0;

      if($pedido['entrega']['forma'] == 'pac'){
        $frete = $pedido['entrega']['valores']['PAC']['valor'];
      }
      else{
        $frete = $pedido['entrega']['valores']['SEDEX']['valor'];
      }

      $frete = (int)($frete * 100);

      $seller_id = MoipAccount::getAccountId($pedido['id_loja']);

      $order->setShippingAmount($frete)
      ->setAddition(0)
      ->setDiscount($discount)
      ->setCustomer($customer)
      ->addReceiver($seller_id, 'PRIMARY', 0, MoipOrder::SELLER_AMOUNT, false)
      ->addReceiver(MoipOrder::ACCOUNT_ID, 'SECONDARY', NULL, MoipOrder::CP_AMOUNT, true)
      ->create();

      $order_id = $order->getId();
      $delivery_method = $pedido['entrega']['forma'];
      $delivery_address = $pedido['entrega']['info'];

      $salvar = Order::salvarPedido($_SESSION['user_id'], $pedido['id_loja'], $order->getId(), $payment_method, $delivery_method, $delivery_address);

      if($salvar){
        return $order;
      }
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
      print_r($e->getMessage());
    }
    return null;
  }

  public static function criarMultiPedidos(Moip $moip, $pedidos, $customer, $payment_method){
    $pedidos_moip = $moip;
    $discount = 0;

    $moip_pedidos = array();

    try{
      $multiorder = $moip->multiorders()->setOwnId(uniqid());
      // PEDIDO POR PEDIDO
      foreach($pedidos as $pedido){
        $order = $pedidos_moip->orders()->setOwnId(uniqid());
        
        // PRODUTOS
        foreach($pedido['produtos'] as $produto){
          $valor = MoipOrder::getPrice($produto['preco']);
          $discount += MoipOrder::getDiscount($produto['preco'], $produto['discount']);
          $order->addItem($produto['nome'], $produto['quantidade'], "Teste de descricao", $valor);
          Product::increaseSolds($produto['id'], $produto['quantidade']);
          Product::lowerStock($produto['id'], $produto['quantidade']);
        }

        // FRETES
        $frete = 0;
        // Taxas
        $seller_id = MoipAccount::getAccountId($pedido['id_loja']);

        $moip_pedidos[] = array(
          'store_id' => $pedido['id_loja'],
          'forma_entrega' => $pedido['entrega']['forma'],
          'entrega' =>  $pedido['entrega']['info']
        );

        $order->setShippingAmount($frete)
        ->setAddition(0)
        ->setDiscount($discount)
        ->setCustomer($customer)
        ->addReceiver($seller_id, 'PRIMARY', 0, MoipOrder::SELLER_AMOUNT, false)
        ->addReceiver(MoipOrder::ACCOUNT_ID, 'SECONDARY', 0, MoipOrder::CP_AMOUNT, true);

        $multiorder->addOrder($order);
      }

      $multiorder = $multiorder->create();

      $multiorder_id = $multiorder->getId();

      foreach($multiorder->getOrderIterator() as $key => $pedido){
        $salvar = Order::salvarPedido($_SESSION['user_id'], $moip_pedidos[$key]['store_id'], $pedido->getId(), $payment_method, $moip_pedidos[$key]['forma_entrega'], $moip_pedidos[$key]['entrega'], $multiorder_id);
      }

      $salvar = Order::salvarPedido($_SESSION['user_id'], null, $multiorder_id, $payment_method, null, null, null);

      return $multiorder;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
      print_r($e->getMessage());
    }
    return null;
  }

  // GETTERS de PEDIDOS

  public static function getSingleOrder(Moip $moip, $order_id){
    try{
      $order = $moip->orders()->get($order_id);
      return $order;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
  }

  public static function getMultiOrder(Moip $moip, $order_id){
    try{
      $multiorder = $moip->multiorders()->get($order_id);
      return $multiorder;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
  }

  private static function getPrice($price){
    $price = (int)($price * 100);
    return $price;
  }

  private static function getDiscount($price, $discount){
    $discounted = $price * ($discount / 100);
    $discounted = (int) ($discounted * 100);
    return $discounted;
  }
}
