<?php

namespace App\Http\Controllers;

use Moip\Moip;
use Moip\Auth\OAuth;

use App\MoipOrder;
use App\User;
use App\Store;
use App\Sales;
use App\EmailSender;

use DB;

class SalesController extends Controller
{

  public function addTrackingCode(){
    $data = $this->get_post();
    $condicoes = array(['id', $data['id']]);
    $venda = array('tracking_code' => $data['tracking_code']);

    $alterou = DB::table('pedidos')
    ->where($condicoes)
    ->update($venda);

    $pedido = DB::table('pedidos')
    ->join(User::TABLE_NAME, User::TABLE_NAME . '.id', '=', 'pedidos.buyer_id')
    ->select('pedidos.order_id', 'pedidos.tracking_code', 'pedidos.buyer_id', User::TABLE_NAME . '.name', User::TABLE_NAME . '.last_name', User::TABLE_NAME . '.email')
    ->where('pedidos.unique_id', $data['unique_id'])
    ->get();

    if($alterou){
      if(count($pedido) > 0){
        $pedido = (array)$pedido[0];
        $pedido['email'] = "yves_henry13@hotmail.com";
        $user = User::grabUserById($_SESSION['user_id']);
        EmailSender::enviarPedidoEnviado($pedido['order_id'], $pedido['tracking_code'], $user['name'] . " " .$user['last_name'], $pedido['email']);
      }
      
      return;
    }
    else{
      $this->return->setFailed("Ocorreu um erro ao cadastrar o código de rastreamento.");
      return;
    }
  }

  public function getOrder(){
    $this->isLogged();
    $data = $this->get_post();

    $loja_id = Store::getStoreID($_SESSION['user_id']);

    if($loja_id == null){
      $this->return->setFailed("O usuário logado não possui uma loja.");
      return;
    }

    $venda = Sales::getOrder($data['unique_id'], $loja_id);

    if($venda != null){
      $access_token = "a4face756e9e4e5c977b0b6449d4e168_v2";
      $moip = new Moip(new OAuth($access_token), Moip::ENDPOINT_PRODUCTION);

      if($this->isMultiPedido($venda->order_id)){
        $this->return->setFailed("Nenhum pedido foi encontrado.");
        return;
      }
      else{
        $pedido = MoipOrder::getSingleOrder($moip, $venda->order_id);
        if($pedido != null){
          $venda->products = $pedido->getItemIterator();
          $venda->price = $pedido->getSubtotalItems()/100;
          $venda->frete = $pedido->getSubtotalShipping()/100;
          $venda->status = $pedido->getStatus();
          $this->return->setObject($venda);
        }
        else{
          $this->return->setFailed("Ocorreu um erro ao receber as informações do seu pedido.");
          return;
        }
      }
    }
    else{
      $this->return->setFailed("Nenhuma venda foi encontrada com este identificador.");
    }
  }

  public function getNumberOfSales(){
    $sales = DB::table('pedidos')
    ->where('seller_id', $_SESSION['user_id'])
    ->select('*')
    ->get();

    $number_sales = count($sales);

    if($number_sales <= 0){
      $this->return->setObject(0);
    }else{
      $this->return->setObject($number_sales);
    }
  }

  public function getSales(){
    $this->isLogged();
    $data = $this->get_post();
    $filtro = null;
    // ID DA LOJA
    $store_id = Store::getStoreID($_SESSION['user_id']);
    
    if($store_id == null){
      $this->return->setFailed("Ocorreu um erro ao localizar sua loja.");
      return;
    }

    if(isset($data['filter'])){
      $filtro = $data['filter'];
    }

    // Verifica a página
    if(!isset($data['page']) || $data['page'] < 0){
      $vendas = Sales::getAll($store_id, $filtro);
    }
    else{
      $page = $data['page'] - 1;
      $vendas = Sales::getAll($store_id, $filtro, $page);
    }

    if($vendas != null){
      $this->return->setObject($vendas);
    }
    else{
      $this->return->setFailed("Nenhum pedido foi encontrado.");
    }
  }

  private function isMultiPedido($unique_id){
    if(substr($unique_id,0,3) == 'MOR'){
      return true;
    }
    else{
      return false;
    }
  }
}
