<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use StdClass;

use App\Store;
use App\Product;

class Cart extends Model
{
    public static function add($product_id, $quantity){
        $response = new StdClass;
        $response->success = false;
        $response->message = "";

        $produto = Product::getProductInfoForCart($product_id, $quantity);

        // Produto não existe
        if($produto == null){
            $response->message .= "Nenhum produto com este identificador foi encontrado.";
            return $response;
        }

        // O Produto pertence ao usuário?
        if(isset($_SESSION['user_id'])){
            if(Store::isMyStore($_SESSION['user_id'], $produto['loja'])){
                $response->message .= "Este produto pertence à sua loja.";
                return $response;
            }
        }
        
        $produto_id = $produto['id'];
        $loja_id = $produto['loja'];
        // A loja já existe?
        if(array_key_exists($loja_id, $_SESSION['cart'])){
            // Se o produto já existe
            if(array_key_exists($produto_id, $_SESSION['cart'][$loja_id])){
                $_SESSION['cart'][$loja_id]['produtos'][$produto_id]['quantidade'] += $quantity;
            }
            else{
                // Se o produto não existe
                $_SESSION['cart'][$loja_id]['produtos'][$produto_id] = array(
                    'quantidade' => $quantity
                );
            }
        }
        else{
            // Se a loja não existe
            $_SESSION['cart'][$loja_id] = array(
                'produtos' => array(
                    $produto_id => array(
                        'quantidade' => $quantity
                    )
                )
            );
        }
        $response->success = true;

        return $response;
    }

    public static function remove($product_id){
        foreach($_SESSION['cart'] as $loja => $pedido){
            if(array_key_exists($product_id, $pedido['produtos'])){
              unset($_SESSION['cart'][$loja]['produtos'][$product_id]);
              if(count($_SESSION['cart'][$loja]['produtos']) <= 0){
                unset($_SESSION['cart'][$loja]);
              }
              return true;
            }
            else{
                return false;
            }
        }
    }

    public static function getAmountOfProducts(){
        $qtd = 0;
        if(isset($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $pedido){
                foreach($pedido['produtos'] as $produto){
                    $qtd += $produto['quantidade'];
                }
            }

            if($qtd <= 0){
                return "Vaz.";
            }
            else{
                return $qtd;
            }
        }
        else{
            return "Vaz.";
        }
    }

    public static function getCart(){
        $carrinho = array();
        if(isset($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $loja => $pedido){
                $nome_da_loja = Store::getStoreName($loja);
                $carrinho[$loja] = array(
                  'id' => $loja,
                  'nome_loja' => $nome_da_loja,
                  'produtos' => Cart::getProducts($pedido['produtos'])
                );
              }            
        }
        return $carrinho;
    }

    private static function getProducts($products){
        $prods = array();
        foreach($products as $id => $product){
            $produto = Product::getProductInfoForCart($id, $product['quantidade']);
            unset($produto['estoque']);
            $produtos[$id] = $produto;
            $produtos[$id]['imagem'] = $produto['imagem'];
            $produtos[$id]['quantidade'] = $product['quantidade'];
        }
        return $produtos;
    }

    public static function clearCart(){
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
}
