<?php

namespace App\Http\Controllers;

use App\Address;
use App\Produtos;
use App\Lojas;
use DB;

class CheckoutController extends Controller
{

  public function createSessionOrder(){
    $_SESSION['order'] = array();

    if(isset($_SESSION['cart'])){
      $_SESSION['order'] = $this->transform($_SESSION['cart']);
    }
    else{
      $this->return->setFailed("Pedido inválido.");
    }
  }

  public function transform($cart){
    $pedidos = array();

    foreach($cart as $loja => $pedido){
      $pedidos[$loja] = array(
        'id_loja' => $loja,
        'nome_loja' => Lojas::pegaNomeLoja($loja),
        'produtos' => array()
      );
      foreach($pedido['produtos'] as $id => $produto){
        $product = Produtos::pegarParaCarrinhoFoto($id);
        $pedidos[$loja]['produtos'][$id] = array(
          'id' => $product['id'],
          'nome' => $product['nome'],
          'preco' => $product['preco'],
          'quantidade' => $produto['quantidade'],
          'imagem' => $product['imagem']
        );
      }
    }

    return $pedidos;

  }

  public function getOrders(){
    if(count($_SESSION['order']) > 0){
      $this->return->setObject($_SESSION['order']);
    }
    else{
      $this->return->setFailed("Nenhum pedido foi encontrado.");
    }
  }

  public function finalize(){
    $data = $this->get_post();
    $data = json_decode(json_encode($data), true);

    if(count($_SESSION['order']) > 0 && count($data) > 0){
      foreach($data as $key => $pedido){
        if(isset($_SESSION['order'][$key])){
          $_SESSION['order'][$key]['entrega']['forma'] = $data[$key]['entrega']['forma'];
          $_SESSION['order'][$key]['entrega']['valores'] = $data[$key]['entrega']['valores'];
        }
      }
    }
    else{
      $this->return->setFailed("Pedidos inválidos.");
      return;
    }
  }

  public function setDeliveries(){
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

  public function reviewOrder(){
    $this->isLogged();
    if(count($_SESSION['order']) > 0){
      foreach($_SESSION['order'] as $key => $pedido){
        if($_SESSION['order'][$key]['entrega']['type'] == 'user'){
          $_SESSION['order'][$key]['entrega']['info'] = Address::pegarEndereco($_SESSION['user_id']);
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

    if(isset($data['valores'])){
      if(isset($data['valores']['info'])){

        $cep_destino = $data['valores']['info']['cep'];
        $cep_origem = Address::getCEP($data['info']['id_loja']);
        // Retira o hifen
        $cep_origem = str_ireplace("-","",$cep_origem);
        $cep_destino = str_ireplace("-", "", $cep_destino);

        foreach($data['info']['produtos'] as $produto){

          $product = DB::table('products')
          ->select('width as largura', 'height as altura', 'weight as peso', 'length as comprimento')
          ->where('id', $produto['id'])
          ->get();

          if(count($product) > 0){
            $product = (array)$product[0];
            // Calcula o volume de cada objeto e soma
            $area_total += (($product['largura'] * $product['altura'] * $product['comprimento']) * $produto['quantidade']);
            // Calcula o peso em Kg
            $peso_total += $product['peso']/1000;
          }
          else{
            $this->return->setFailed("Nenhum produto não foi encontrado no nosso banco de dados.");
            return;
          }
        }

        $peso_total = (String)$peso_total;

        $dimensoes = (round (pow($area_total, 1/3)) + 1);

        $valores = Address::calcularValores($cep_origem, $cep_destino, $peso_total, $dimensoes);

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
