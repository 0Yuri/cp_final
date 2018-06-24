<?php

namespace App\Http\Controllers;

use App\Address;
use App\Product;
use App\Store;
use DB;

class CheckoutController extends Controller
{

  // OK
  public function createSessionOrder(){
    $_SESSION['order'] = array();

    if(isset($_SESSION['cart'])){
      $_SESSION['order'] = $this->transform($_SESSION['cart']);
    }
    else{
      $this->return->setFailed("Pedido inválido.");
    }
  }

  // OK
  public function transform($cart){
    $pedidos = array();

    foreach($cart as $loja => $pedido){
      $pedidos[$loja] = array(
        'id_loja' => $loja,
        'nome_loja' => Store::getStoreName($loja),
        'produtos' => array()
      );
      foreach($pedido['produtos'] as $id => $produto){
        $product = Product::getProductInfoForCart($id);
        $pedidos[$loja]['produtos'][$id] = array(
          'id' => $product['id'],
          'nome' => $product['nome'],
          'desconto' => $product['discount'],
          'preco' => $product['preco'],
          'quantidade' => $produto['quantidade'],
          'imagem' => $product['imagem']
        );
      }
    }

    return $pedidos;

  }

  // OK
  public function getOrders(){
    if(count($_SESSION['order']) > 0){
      $this->return->setObject($_SESSION['order']);
    }
    else{
      $this->return->setFailed("Nenhum pedido foi encontrado.");
    }
  }

  // OK
  public function finalize(){
    $data = $this->get_post();
    $data = json_decode(json_encode($data), true);

    if(isset($_SESSION['pagamento'])){
      unset($_SESSION['pagamento']);
    }

    if(count($_SESSION['order']) > 0 && count($data) > 0){
      foreach($data as $key => $pedido){
        if(isset($_SESSION['order'][$key])){
          if(isset($data[$key]['entrega']['forma'])){
            $_SESSION['order'][$key]['entrega']['forma'] = $data[$key]['entrega']['forma'];
            $_SESSION['order'][$key]['entrega']['valores'] = $data[$key]['entrega']['valores'];
            return;
          }
          else{            
            $this->return->setFailed("Nenhuma forma de envio foi definida.");
          }
          
        }
      }
    }
    else{
      $this->return->setFailed("Pedidos inválidos.");
      return;
    }
  }

  // OK
  public function setDeliveries(){
    $this->isLogged();
    $data = $this->get_post();
    $data = json_decode(json_encode($data), true);

    foreach($data as $key => $pedido){
      if(isset($_SESSION['order'][$key])){
        $_SESSION['order'][$key]['entrega'] = $data[$key]['entrega'];
      }
      else{
        $this->return->setFailed("Ocorreu um problema ao definir a entrega do seu pedido.");
        return;
      }
    }
  }

  // OK
  public function reviewOrder(){
    // TODO: Alguma forma de pedir o usuário que logue
    $this->isLogged();

    if(count($_SESSION['order']) > 0){
      foreach($_SESSION['order'] as $key => $pedido){
        if($_SESSION['order'][$key]['entrega']['type'] == 'user'){
          $_SESSION['order'][$key]['entrega']['info'] = Address::getUserAddress($_SESSION['user_id']);
        }
      }

      $this->return->setObject($_SESSION['order']);
    }
    else{
      $this->return->setFailed("Nenhum pedido foi encontrado.");
      return;
    }
  }
  
  public function calculateDelivery(){
    $data = $this->get_post();
    $data = json_decode(json_encode($data), true);
    $area_total = 0;
    $peso_total = 0;
    $preco = 0;


    if(isset($data['valores'])){
      if(isset($data['valores']['info'])){

        $cep_destino = $data['valores']['info']['cep'];
        $cep_origem = Address::getCepByStore($data['info']['id_loja']);
        // Retira o hifen
        $cep_origem = str_ireplace("-","",$cep_origem);
        $cep_destino = str_ireplace("-", "", $cep_destino);

        foreach($data['info']['produtos'] as $produto){

          $product = DB::table('products')
          ->select('width as largura', 'height as altura', 'weight as peso', 'length as comprimento', 'price as preco')
          ->where('id', $produto['id'])
          ->get();

          if(count($product) > 0){
             $product = (array)$product[0];
             $area_total += (($product['altura'] * $product['largura'] * $product['comprimento']) * $produto['quantidade']);
             $preco += round($product['preco']);
             $peso_total += (($product['peso']/1000) * $produto['quantidade']);
          }
          else{
            $this->return->setFailed("Nenhum produto não foi encontrado no nosso banco de dados.");
            return;
          }
        }

        $preco = (String)($preco+1);
        $dimensoes = (String)round(pow($area_total, 1/3));
        $peso_total = (String)$peso_total;

        $valores = Address::calculateValues($cep_origem, $cep_destino, $peso_total, $dimensoes);

        $this->return->setObject($valores);

      }
      else{
        $this->return->setFailed("Nenhum endereço de entrega foi definido.");
        return;
      }
    }
    else{
      $this->return->setFailed("Nenhum endereço de entrega foi recebido.");
      return;
    }
  }

}
