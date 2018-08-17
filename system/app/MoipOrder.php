<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Moip\Moip;
use Moip\Auth\OAuth;
use DB;

use App\EmailSender;
use App\Order;
use App\Moip as MoipConstants;


class MoipOrder extends Model
{
  // Conta do moip
  // Taxas Vendedor e Crespass
  const SELLER_AMOUNT = 80;
  const CP_AMOUNT = 20;

  // CRIAR TIPOS DE PEDIDOS

  public static function criarPedidoSimples(Moip $moip, $pedido, $customer, $payment_method){
    try{
      $discount = 0;
      $order = $moip->orders()->setOwnId(uniqid());

      foreach($pedido['produtos'] as $produto){
        // Conversão do valor para integer
        $valor = MoipOrder::getPrice($produto['preco']);
        // Adição de desconto se existir
        $discount += MoipOrder::getDiscount($produto['preco'] * $produto['quantidade'], $produto['desconto']);
        // Adição do produto ao pedido
        $order->addItem($produto['nome'], $produto['quantidade'], "Descricao teste", $valor);
        // Logistica do estoque e número de vendas
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
      ->addReceiver($seller_id, 'PRIMARY', 0, MoipConstants::SELLER_AMOUNT, false)
      ->addReceiver(MoipConstants::OWNER_ACCOUNT, 'SECONDARY', NULL, MoipConstants::CP_AMOUNT, true)
      ->create();

      $order_id = $order->getId();
      $delivery_method = $pedido['entrega']['forma'];
      $delivery_address = $pedido['entrega']['info'];

      // Envio de emails após compra
      $donoDaLoja = Store::getOwnerOfStore($pedido['id_loja']);
      $comprador = User::grabUserById($_SESSION['user_id']);

      if($donoDaLoja != null && $comprador != null){
        EmailSender::enviarProdutosVendidos($pedido['produtos'], $donoDaLoja['name'] . " " . $donoDaLoja['last_name'], $comprador['name'] . " " . $comprador['last_name'], $donoDaLoja['email']);
        EmailSender::enviarPedidoCriado($order_id, $comprador['name'] . " " . $comprador['last_name'], $pedido, $comprador['email']);
      }
      
      // Armazenamento de pedido
      $salvar = Order::salvarPedido($_SESSION['user_id'], $pedido['id_loja'], $order->getId(), $payment_method, $delivery_method, $delivery_address);

      if($salvar){
        return $order;
      }
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401 
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
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
          // Conversão do valor para integer
          $valor = MoipOrder::getPrice($produto['preco']);
          // Adição de desconto se existir
          $discount += MoipOrder::getDiscount($produto['preco'], $produto['desconto']);
          // Adição do produto ao pedido
          $order->addItem($produto['nome'], $produto['quantidade'], "Teste de descricao", $valor);
          // Logistica do estoque e número de vendas
          Product::increaseSolds($produto['id'], $produto['quantidade']);
          Product::lowerStock($produto['id'], $produto['quantidade']);
        }

        // FRETES
        $frete = 0;

        if($pedido['entrega']['forma'] == 'pac'){
          $frete = $pedido['entrega']['valores']['PAC']['valor'];
        }
        else{
          $frete = $pedido['entrega']['valores']['SEDEX']['valor'];
        }
  
        $frete = (int)($frete * 100);

        // Taxas
        $seller_id = MoipAccount::getAccountId($pedido['id_loja']);

        $moip_pedidos[] = array(
          'store_id' => $pedido['id_loja'],
          'forma_entrega' => $pedido['entrega']['forma'],
          'entrega' =>  $pedido['entrega']['info'],
          'pedido' => $pedido
        );

        $order->setShippingAmount($frete)
        ->setAddition(0)
        ->setDiscount($discount)
        ->setCustomer($customer)
        ->addReceiver($seller_id, 'PRIMARY', 0, MoipConstants::SELLER_AMOUNT, false)
        ->addReceiver(MoipConstants::OWNER_ACCOUNT, 'SECONDARY', 0, MoipConstants::CP_AMOUNT, true);        

        $multiorder->addOrder($order);
      }
      
      if(!Cart::ValidarPedido($multiorder->getAmountTotal())){
        return null;
      }

      $multiorder = $multiorder->create();
      $multiorder_id = $multiorder->getId();

      // Armazenamento de pedidos
      foreach($multiorder->getOrderIterator() as $key => $pedido){
        $order_id = $pedido->getId();
        $salvar = Order::salvarPedido($_SESSION['user_id'], $moip_pedidos[$key]['store_id'], $order_id, $payment_method, $moip_pedidos[$key]['forma_entrega'], $moip_pedidos[$key]['entrega'], $multiorder_id);

        // Envio de emails após compra
        $donoDaLoja = Store::getOwnerOfStore($moip_pedidos[$key]['store_id']);
        $comprador = User::grabUserById($_SESSION['user_id']);

        if($comprador != null && $donoDaLoja != null){
          EmailSender::enviarProdutosVendidos($moip_pedidos[$key]['pedido']['produtos'] , $donoDaLoja['name'] . " " . $donoDaLoja['last_name'], $comprador['name'] . " " . $comprador['last_name'], $donoDaLoja['email']);
          EmailSender::enviarPedidoCriado($order_id, $comprador['name'] . " " . $comprador['last_name'], $moip_pedidos[$key]['pedido'], $comprador['email']);
        }
        
      }

      // Armazenamento de Multipedido - referencia
      $salvar = Order::salvarPedido($_SESSION['user_id'], null, $multiorder_id, $payment_method, null, null, null);

      return $multiorder;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401
      
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
      
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
      
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
      
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      
    }
  }

  public static function getMultiOrder(Moip $moip, $order_id){
    try{
      $multiorder = $moip->multiorders()->get($order_id);
      return $multiorder;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      
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
