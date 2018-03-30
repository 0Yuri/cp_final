<?php

namespace App\Http\Controllers;

use DB;

use App\Address;
use App\Store;
use App\Product;
use App\Cart;

class CartController extends Controller
{

  public function __construct(){
    parent::__construct();
    if(!isset($_SESSION['cart'])){
      $_SESSION['cart'] = array();
    }
  }

  // Adicionar produto ao carrinho
  public function addProduct(){
    $data = $this->get_post();

    $produto_id = $data['id'];
    $quantidade = $data['quantity'];

    $status = Cart::add($produto_id, $quantidade);

    if(!$status->success){
      $this->return->setFailed($status->message);
      $this->return->setObject($status);
      return;
    }    
  }
  // Remove produto do carrinho
  public function removeProduct(){
    $data = $this->get_post();
    $status = Cart::remove($data['product']);
    if(!$status){
      $this->return->setFailed("Não foi possível excluir o produto do carrinho.");
      return;
    }
  }
  // Altera a quantidade
  public function changeQuantityOfProduct(){
    $data = $this->get_post();
    $product_id = $data['product'];
    $valor = $data['value'];

    $estoque = Product::getProductStock($product_id);

    if($estoque != null){
      // Varre cada pedido
      foreach($_SESSION['cart'] as $loja => $pedido){
        // Verifica se o produto existe nesse pedido
        if(array_key_exists($product_id, $pedido['produtos'])){
          // Soma a quantidade final desejada
          $atual = $pedido['produtos'][$product_id]['quantidade'] + $valor;
          // Verifica se a quantidade é maior que o estoque disponível
          if($atual > $estoque){
            // Se for, estoque será a quantidade máxima é definida
            $atual = $estoque;
          }else if($atual <= 0){
            $atual = 1;
          }
          $_SESSION['cart'][$loja]['produtos'][$product_id]['quantidade'] = $atual;
        }
      }
    }
    else{
      $this->return->setFailed("Nenhum produto foi encontrado.");
      return;
    }


  }
  // Número de produtos ativos
  public function number(){    
    $this->return->setObject(Cart::getAmountOfProducts());
  }
  // Limpa o carrinho
  public function clear(){
    // Pedido
    if(isset($_SESSION['order'])){
      unset($_SESSION['order']);
    }
    // Carrinho
    if(isset($_SESSION['cart'])){
      unset($_SESSION['cart']);
    }
    $_SESSION['cart'] = array();
  }

  // Calcula o frete de cada pedido no carrinho
  public function GetDeliveryValues(){
    $data = $this->get_post();

    $cep_destino = str_ireplace("-", "", $data['cep']);
    $cep_origem = str_ireplace("-", "", Address::getCepByStore($data['id']));

    $area_total = 0;
    $peso = 0;
    $preco = 0;

    foreach($data['produtos'] as $key => $produto){

      $product = DB::table('products')
      ->select('height as altura', 'width as largura', 'weight as peso', 'length as comprimento', 'price as preco')
      ->where('id', $key)
      ->get();

      if(count($product) > 0){
        $product = (array)$product[0];
        $area_total += (($product['altura'] * $product['largura'] * $product['comprimento']) * $produto->quantidade);
        $preco += round($product['preco']);
        $peso += (($product['peso']/1000) * $produto->quantidade);
      }
      else{
        $this->return->setFailed("Um produto do carrinho não foi encontrado.");
      }
    }

    $preco = (String)($preco+1);
    $dimensoes = (String)round(pow($area_total, 1/3));
    $peso = (String)$peso;

    $precos = Address::calculateValues($cep_origem, $cep_destino, $peso, $dimensoes, $preco);

    $this->return->setObject($precos);

  }

  // Retorna a sacolinha
  public function get(){
    $this->return->setObject(Cart::getCart());
  }

}
