<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\User;
use App\Store;

class Product extends Model
{

  const TABLE_NAME = "products";

  public static function pegarInfo($id, $quantidade){
    $produto = DB::table(Product::TABLE_NAME)
    ->select('id', 'name', 'description', 'price', 'price', 'discount')
    ->where('id', $id)
    ->get();

    if(count($produto) > 0){
      $produto = (array)$produto[0];
      $produto['quantidade'] = $quantidade;
      return $produto;
    }
    else{
      return null;
    }
  }

  public static function getProductInfoForCart($id, $quantidade = 0){
    $produto = DB::table(Product::TABLE_NAME)
    ->join('stores', 'stores.id', '=', 'products.store_id')
    ->join('product_images', 'product_images.product_id', 'products.id')
    ->select('products.id', 'products.name as nome', 'products.price as preco', 'products.discount', 'products.stock', 'stores.id as loja', 'stores.name as loja_nome', 'product_images.filename as imagem')
    ->where('product_images.type', 'profile')
    ->where('products.id', $id)
    ->get();

    if(count($produto) > 0){
      $produto = (array)$produto[0];
      $produto['quantidade'] = $quantidade;
      return $produto;
    }
    else{
      return null;
    }
  }

  // Pega produtos da loja do usuário logado.
  public static function getLoggedStoreProducts($id, $page=0, $take = 8){
    $produtos = DB::table(User::TABLE_NAME)
    ->join(Store::TABLE_NAME, 'stores.owner_id', '=', 'users.id')
    ->join(Product::TABLE_NAME, 'products.store_id', '=', 'stores.id')
    ->join('product_images', 'product_images.product_id', 'products.id')
    ->select('products.*', 'product_images.filename as imagem')
    ->skip($page * $take)
    ->take($take)
    ->where('users.id', '=', $id)
    ->where('product_images.type', 'profile')
    ->get();

    // Calcula a Quantidade de paginas
    $qtd_produtos = DB::table(User::TABLE_NAME)
    ->join(Store::TABLE_NAME, 'stores.owner_id', '=', 'users.id')
    ->join(Product::TABLE_NAME, 'products.store_id', '=', 'stores.id')
    ->where('users.id', '=', $id)
    ->count();

    // Se os produtos forem menor que a de exibição(12) Existe apenas uma página
    if($qtd_produtos < $take){
      $qtd_paginas = 1;
    }
    else{
      $resto = $qtd_produtos%$take;

      $qtd_paginas = ($qtd_produtos - $resto) / $take;

      if($resto > 0){
        $qtd_paginas++;
      }
    }

    if(count($produtos) > 0){
      return array(
        'paginas' => $qtd_paginas,
        'produtos' => $produtos
      );
    }else{
      return null;
    }
  }

  // Pega determinado produto do usuário logado
  public static function getEditableProduct($unique_id, $id){
    $produto = DB::table(User::TABLE_NAME)
    ->join(Store::TABLE_NAME, 'stores.owner_id', '=', 'users.id')
    ->join(Product::TABLE_NAME, 'products.store_id', '=', 'stores.id')
    ->where('users.id', $id) // Garantir que o produto é seu, pertence a sua loja
    ->where('products.unique_id', $unique_id)
    ->select('products.*')
    ->get();

    if(count($produto) > 0){
      $produto = $produto[0];

      $imagem = DB::table('product_images')
      ->select('id', 'filename')
      ->where('product_images.product_id', '=', $produto->id)
      ->where('product_images.type', 'profile')
      ->get();

      $produto->profile_image = $imagem[0];

      $extras = DB::table('product_images')
      ->select('id', 'filename')
      ->where('product_images.product_id', '=', $produto->id)
      ->where('product_images.type', 'extra')
      ->get();

      $produto->imagens = $extras;

      return $produto;
    }else{
      return null;
    }
  }

  // Pega id da loja do usuário
  public static function pegarID($id){
    $store = DB::table('users')
    ->join('stores', 'users.id', '=', 'stores.owner_id')
    ->select('stores.id')
    ->where('users.id', $id)
    ->get();

    $store = (array)$store[0];
    $loja_id = $store['id'];

    return $loja_id;

  }

  // Pega o id do produto pelo nome
  public static function pegarIDPerName($name){
    $produto = DB::table('products')
    ->select('id')
    ->where('name', $name)
    ->get();

    $produto_id = (array)$produto[0];

    return $produto_id['id'];
  }

  // Edita o produto
  public static function updateProduct($data){
    $alterar = DB::table('products')
    ->where('id', $data['id'])
    ->update($data);

    if($alterar){
      return true;
    }else{
      return false;
    }
  }

  // Salva um produto novo
  public static function saveProduct($data){
    if(isset($data['imagem'])){
      unset($data['imagem']);
    }
    $adicionar = DB::table('products')
    ->insertGetId($data);

    if($adicionar){
      return $adicionar;
    }else{
      return false;
    }
  }

  // Alterna de ativado e desativado
  public static function toggleProductStatus($data){
    $status;
    if($data['status'] == 'ativado'){
      $status = 'desativado';
    }
    else{
      $status = 'ativado';
    }

    $updated = DB::table(Product::TABLE_NAME)
    ->where('unique_id', $data['unique_id'])
    ->update(['status' => $status]);

    if($updated){
      return true;
    }
    else{
      return false;
    }
  }

  // Pega os produtos de uma loja
  public static function getProductsFromStore($store_id){

    $products = DB::table('stores')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->join('product_images', 'product_images.product_id', '=', 'products.id')
    ->select('products.unique_id', 'products.name', 'products.quality', 'products.price', 'products.gender', 'product_images.filename as imagem')
    ->where('stores.unique_id', '=', $store_id)
    ->where('product_images.type', 'profile')
    ->where("products.status", "ativado")
    ->get();

    return $products;

  }

  // Aumenta quantidade de unidades vendidas
  public static function increaseSolds($product_id, $amount){
    $status = DB::table(Product::TABLE_NAME)
    ->where('id', $product_id)
    ->increment('solds', $amount);

    if($status){
      return true;
    }
    else{
      return false;
    }
  }

  // Diminui a quantidade de estoque
  public static function lowerStock($product_id, $amount){
    $product = DB::table(Product::TABLE_NAME)
    ->select("stock")
    ->where("id", $product_id)
    ->get();

    if(count($product) > 0){
      $product = $product[0];
      if($product->stock == 0){
        return false;
      }
    }
    else{
      return false;
    }

    $status = DB::table(Product::TABLE_NAME)
    ->where('id', $product_id)
    ->decrement("stock", $amount);

    if($status){
      return true;
    }
    else{
      return false;
    }
  }

  // Numero de produtos ativos dividido por 8, retorna a quantidade da paginas
  public static function quantityOfFilteredProducts($condicoes, $take= 8){
    $qtd_produtos = DB::table('products')
    ->where($condicoes)
    ->count();
    
    if($qtd_produtos < $take){
      return 1;
    }
    
    $resto = $qtd_produtos%$take;

    $qtd_paginas = ($qtd_produtos-$resto)/$take;

    if($resto > 0){
      $qtd_paginas++;
    }

    return $qtd_paginas;
    
  }

  // Retorna o produto de acordo com o nome
  public static function getViewableProduct($unique_id){
    $produto = DB::table('products')
    ->select('*')
    ->where('products.unique_id', $unique_id)
    ->get();

    if(count($produto) > 0){
      $produto = (array)$produto[0];


      $perfil = DB::table('product_images')
      ->select('id', 'product_id', 'filename')
      ->where('product_id', $produto['id'])
      ->where('type', 'profile')
      ->get();

      if(count($perfil) > 0){
        $perfil = $perfil[0];
        $produto['profile_image'] = $perfil->filename;
      }

      $outras = DB::table('product_images')
      ->select('id', 'product_id', 'filename')
      ->where('product_id', $produto['id'])
      ->where('type', 'extra')
      ->get();

      $produto['imagens'] = $outras;

      return $produto;
    }
    else{
      return null;
    }
  }

  public static function produtoCarrinho($id){
    $produto = DB::table('products')
    ->select('name', 'description', 'discount', 'price')
    ->where('id', $id)
    ->get();

    if(count($produto) > 0){
      return (array)$produto[0];
    }
    else{
      return null;
    }
  }

  public static function getProductStock($product_id){
    $produto = DB::table('products')
    ->select('stock')
    ->where('id', $product_id)
    ->get();

    if(count($produto) > 0){
      return $produto[0]->stock;
    }
    else{
      return null;
    }
  }

  // Pega os produtos filtrados
  public static function getProducts($condicoes, $page=0, $take = 8){
    $products = DB::table(Product::TABLE_NAME)
    ->join('product_images', 'product_images.product_id', '=', Product::TABLE_NAME . '.id')
    ->select(
      Product::TABLE_NAME . '.name',
      Product::TABLE_NAME . '.price',
      Product::TABLE_NAME . '.quality',
      Product::TABLE_NAME . '.discount',
      Product::TABLE_NAME . '.gender',
      Product::TABLE_NAME . '.unique_id',
      'product_images.filename as imagem'
      )
    ->where($condicoes)
    ->where('product_images.type', 'profile')
    ->where('status', 'ativado')
    ->where('stock', '>', 0)
    ->skip($page * $take)
    ->take($take)
    ->get();

    return $products;

  }

  public static function saveImage($product_id, $nome, $type="extra"){
    $data = array(
      'type' => $type,
      'product_id' => $product_id,
      'filename' => $nome
    );

    $added = DB::table('product_images')
    ->insert($data);

    if($added){
      return true;
    }
    else{
      return false;
    }
  }
}
