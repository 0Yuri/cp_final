<?php

namespace App\Http\Controllers;

use DB;

use App\Address;
use App\Store;
use App\Product;

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

    $produto = Product::getProductInfoForCart($produto_id, $quantidade);

    if($produto != null){
      $loja_id = $produto['loja'];
      if(!Store::isMyStore($_SESSION['user_id'], $loja_id)){
        $this->return->setFailed("Esse produto pertence a sua loja.");
        return;
      }
    }
    else{
      $this->return->setFailed("Nenhum produto foi encontrado com este identificador.");
      return;
    }

    if($quantidade > $produto['stock']){
      $quantidade = $produto['stock'];
    }

    // Verifica se já existe a loja
    if(array_key_exists($loja_id, $_SESSION['cart'])){
      // Verifica se já existe o produto
      if(array_key_exists($produto_id, $_SESSION['cart'][$loja_id]['produtos'])){
        // Se existe, aumenta a quantidade
        $futura = $_SESSION['cart'][$loja_id]['produtos'][$produto_id]['quantidade'] + $quantidade;
        // Se a quantidade anterior mais a nova adicionada for maior que o estoque, então a quantidade vai ser o estoque total
        if($futura > $produto['stock']){
          $futura = $produto['stock'];
        }
        // Define o valor final da quantidade
        $_SESSION['cart'][$loja_id]['produtos'][$produto_id]['quantidade'] = $futura;
      }
      else{
        // se não, cria o produto
        $_SESSION['cart'][$loja_id]['produtos'][$produto_id] = array(
          'quantidade' => $quantidade
        );
      }
    }
    // Caso não exista loja
    else{
      // Cria a loja
      $_SESSION['cart'][$loja_id] = array(
        'produtos' => array(
          $produto_id => array(
            'quantidade' => $quantidade
          )
        )
      );
    }
  }
  // Remove produto do carrinho
  public function removeProduct(){
    $data = $this->get_post();

    $product_id = $data['product'];

    foreach($_SESSION['cart'] as $loja => $pedido){
      if(array_key_exists($product_id, $pedido['produtos'])){
        unset($_SESSION['cart'][$loja]['produtos'][$product_id]);
        if(count($_SESSION['cart'][$loja]['produtos']) <= 0){
          unset($_SESSION['cart'][$loja]);
        }
      }
    }

  }
  // Altera a quantidade
  public function changeQuantityOfProduct(){
    $data = $this->get_post();
    $product_id = $data['product'];
    $valor = $data['value'];

    $estoque = Product::getProductStock($product_id);

    if($estoque != null){
      $estoque = $produto[0]->stock;

      foreach($_SESSION['cart'] as $loja => $pedido){
        if(array_key_exists($product_id, $pedido['produtos'])){
          $atual = $pedido['produtos'][$product_id]['quantidade'] + $valor;
          if($atual > $estoque){
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
    if(count($_SESSION['cart']) > 0){
      $qtd = 0;

      foreach($_SESSION['cart'] as $pedido){
        foreach($pedido['produtos'] as $produto){
          $qtd += $produto['quantidade'];
        }
      }

      if($qtd <= 0){
        $this->return->setObject("Vaz.");
      }
      else{
        $this->return->setObject($qtd);
      }
    }
    else{
      $this->return->setObject("Vaz.");
    }
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
    $cep_origem = str_ireplace("-", "", Address::getCEP($data['id']));

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

    $precos = Address::calcularValores($cep_origem, $cep_destino, $peso, $dimensoes, $preco);

    $this->return->setObject($precos);

  }

  // Retorna a sacolinha
  public function get(){
    $carrinho = array();

    foreach($_SESSION['cart'] as $loja => $pedido){
      $nome_da_loja = Store::getStoreName($loja);
      $carrinho[$loja] = array(
        'id' => $loja,
        'nome_loja' => $nome_da_loja,
        'produtos' => $this->getProdutos($pedido['produtos'])
      );
    }

    $this->return->setObject($carrinho);
  }

  // Gera os produtos do carrinho
  private function getProdutos($products){
    $produtos = array();

    foreach($products as $id => $product){
      $produto = Product::getProductInfoForCart($id, $product['quantidade']);
      unset($produto['estoque']);
      $produtos[$id] = $produto;
      $produtos[$id]['imagem'] = $produto['imagem'];
      $produtos[$id]['quantidade'] = $product['quantidade'];
    }

    return $produtos;
  }

}
