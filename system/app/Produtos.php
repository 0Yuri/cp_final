<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Produtos extends Model
{

  // Pega o produto para exibição
  public static function pegarProduto($id){
    $produto = DB::table('products')
    ->join('product_images', 'product_images.product_id', '=', 'products.id')
    ->select('products.id as id', 'products.name', 'products.price', 'products.discount',
    'products.description', 'products.stock', 'product_images.filename as profile_image')
    ->where('products.unique_id', $id)
    ->where('product_images.type', '=', 'profile')
    ->get();

    if(count($produto) > 0){
      $produto = $produto[0];

      $imagens = DB::table('product_images')
      ->select('id', 'filename')
      ->where('product_images.product_id', '=', $produto->id)
      ->where('product_images.type', 'extra')
      ->get();

      $produto->imagens = $imagens;

      return $produto;
    }
    else{
      return null;
    }
  }

  public static function salvarImagem($product_id, $nome, $type="extra"){
    $data = array(
      'type' => $type,
      'product_id' => $product_id,
      'filename' => $nome
    );

    $inserir = DB::table('product_images')
    ->insert($data);

    if($inserir){
      return true;
    }
    else{
      return false;
    }
  }

  // Pega os produtos da loja do usuário logado
  public static function pegarProdutosLogado($user_id, $page=0){
    $produtos = DB::table('users')
    ->join('stores', 'stores.owner_id', '=', 'users.id')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->join('product_images', 'product_images.product_id', '=', 'products.id')
    ->select('products.*', 'product_images.filename as imagem')
    ->skip($page * 12)
    ->take(12)
    ->where('users.id', '=', $user_id)
    ->where('product_images.type', 'profile')
    ->get();

    // Calcula a Quantidade de paginas
    $qtd_produtos = DB::table('users')
    ->join('stores', 'stores.owner_id', '=', 'users.id')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->where('users.id', '=', $user_id)
    ->count();

    // Se os produtos forem menor que a de exibição(12) Existe apenas uma página
    if($qtd_produtos < 12){
      $qtd_paginas = 1;
    }
    else{
      $resto = $qtd_produtos%12;

      $qtd_paginas = ($qtd_produtos - $resto) / 12;

      if($resto > 0){
        $qtd_paginas++;
      }
    }

    if(count($produtos) > 0){
      return array(
        'paginas' => $qtd_paginas,
        'produtos' => $produtos
      );
    }
    else{
      return array(
        'paginas' => 1,
        'produtos' => null
      );
    }

  }

  // Pega um produto do usuario logado para edição
  public static function pegarProdutoLogado($unique_id, $user_id){
    $produto = DB::table('users')
    ->join('stores', 'stores.owner_id', 'users.id')
    ->join('products', 'products.store_id', 'stores.id')
    ->where('users.id', $user_id)
    ->where('products.unique_id', $unique_id)
    ->select('products.*')
    ->get();

    if(count($produto) > 0){
      return $produto[0];
    }else{
      return null;
    }
  }

  // Pega o produto para adicionar no carrinho
  public static function pegarProdutoCarrinho($unique_id){
    $produto = DB::table('products')
    ->join('product_images', 'product_images.product_id', '=', 'products.id')
    ->select('products.id', 'products.name as nome', 'products.price as preco', 'products.discount as desconto', 'products.store_id', 'products.stock as estoque')
    ->where('products.id', $unique_id)
    ->where('product_images.type', '=', 'profile')
    ->get();

    if(count($produto) > 0){
      return (array)$produto[0];
    }
    else{
      return null;
    }
  }

  public static function pegarParaCarrinhoFoto($unique_id){
    $produto = DB::table('products')
    ->join('product_images', 'product_images.product_id', '=', 'products.id')
    ->select('products.id', 'products.name as nome', 'products.price as preco', 'products.discount as desconto', 'products.store_id', 'products.stock as estoque', 'product_images.filename as imagem')
    ->where('products.id', $unique_id)
    ->where('product_images.type', '=', 'profile')
    ->get();

    if(count($produto) > 0){
      return (array)$produto[0];
    }
    else{
      return null;
    }
  }

}
