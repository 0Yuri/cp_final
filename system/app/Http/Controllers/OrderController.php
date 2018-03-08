<?php

namespace App\Http\Controllers;

use App\MoipAccount;
use App\MoipClient;
use App\MoipOrder;

use App\MyOrders;
use App\Address;
use App\Shopping;
use App\User;
use App\Sales;
use App\Order;
use App\Product;

use DB;

class OrderController extends Controller
{

  // Definir Pedido - Criar Pedido
  public function definirPedido(){

    if(isset($_SESSION['order'])){
      unset($_SESSION['order']);
    }

    $pedidos = array();

    if(count($_SESSION['cart']) > 0){
      foreach($_SESSION['cart'] as $key => $pedido){
        $produtos = array();
        foreach($pedido['produtos'] as $ind => $produto){
          array_push($produtos, Product::pegarProdutoCarrinho($produto['id'], $produto['quantidade']));
        }
        array_push($pedidos, array('nome_loja' => $pedido['nome_loja'], 'id_loja' => $pedido['id_loja'], 'produtos' => $produtos));
      }

      $_SESSION['order'] = $pedidos;
    }
    else{
      $this->return->setFailed("Nenhum pedido foi realizado.");
      return;
    }
  }

  private function validarCarrinho($cart){
    $i = 0;
    foreach($cart as $pedido){
      foreach($pedido as $produto){
        $i += $produto['quantity'];
      }
    }

    if($i <= 0){
      return false;
    }
    else{
      return true;
    }
  }

  // Pega todas as compras do usuário
  public function minhas_compras(){
    $data = $this->get_post();
    $this->isLogged();

    if($data['page'] < 0){
      $data['page'] = 0;
    }
    else{
      $data['page'] -= 1;
    }

    $pedidos = Shopping::pegarPedidos($_SESSION['user_id'], $data, $data['page']);

    if($pedidos != null){
      $this->return->setObject($pedidos);
    }
    else{
      $this->return->setFailed("Nenhum pedido foi encontrado.");
    }
  }

  // Recebe os pedidos
  public function pedidos(){
    $this->isLogged();
    if(isset($_SESSION['order']) && count($_SESSION['order']) > 0){
      $this->return->setObject($_SESSION['order']);
    }
    else{
      $this->return->setFailed("Nenhum pedido encontrado.");
      return;
    }
  }

  private function generateOrder($order){
    // Converte objeto em array
    $order = json_decode(json_encode($order), true);
    // IDs das lojas
    $lojas = array_keys($order);
    // Pedido
    $pedido = array();
    // Pedido por pedido
    foreach($order as $key => $value){
      $loja = DB::table('stores')
      ->select('name')
      ->where('id', $key)
      ->get();

      if(count($loja) > 0){
        $loja = $loja[0];
      }

      $produtos = array();

      // Produto por produto
      foreach($value as $key => $value){
        $produto = DB::table('products')
        ->select('id', 'name', 'price', 'discount', 'description')
        ->where('id', $key)
        ->get();

        if(count($produto) > 0){
          $produto = $produto[0];
          $produtos[] = array(
            'id' => $produto->id,
            'nome' => $produto->name,
            'preco' => $produto->price,
            'descricao' => $produto->description,
            'desconto' => $produto->discount,
            'quantidade' => $value['quantity']
          );
        }
      }

      // Cria um pedido
      $pedido[] = array(
        'loja' => $key,
        'loja_nome' => $loja->name,
        'produtos' => $produtos
      );
    };

    return $pedido;
  }

  public function pegarPedidos(){
    if(count($_SESSION['order']) > 0){
      $this->return->setObject($_SESSION['order']);
    }
    else{
      $this->return->setFailed("Nenhum pedido foi encontrado.");
      return;
    }
  }

  public function pedidoID(){
    $data = $this->get_post();
  }


}
