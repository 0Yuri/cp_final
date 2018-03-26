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

  public static function getProductInfoForCart($id, $quantidade){
    $produto = DB::table(Product::TABLE_NAME)
    ->join('stores', 'stores.id', '=', 'products.store_id')
    ->select('products.id', 'products.name', 'products.price', 'products.discount', 'products.stock', 'stores.id as loja', 'stores.name as loja_nome')
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
  public static function getLoggedStoreProducts($id, $page=0){
    $produtos = DB::table(User::TABLE_NAME)
    ->join(Store::TABLE_NAME, 'stores.owner_id', '=', 'users.id')
    ->join(Product::TABLE_NAME, 'products.store_id', '=', 'stores.id')
    ->join('product_images', 'product_images.product_id', 'products.id')
    ->select('products.*', 'product_images.filename as imagem')
    ->skip($page * 12)
    ->take(12)
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
  public static function increaseSolds($amount){
    $status = DB::table(Product::TABLE_NAME)
    ->increment('solds', $amount);

    if($status){
      return true;
    }
    else{
      return false;
    }
  }

  // Diminui a quantidade de estoque
  public static function lowerStock($amount){
    $status = DB::table(Product::TABLE_NAME)
    ->decrement("stock", $amount);

    if($status){
      return true;
    }
    else{
      return false;
    }
  }

  // Numero de produtos ativos dividido por 8, retorna a quantidade da paginas
  public static function quantityOfFilteredProducts($condicoes){
    $qtd_produtos = DB::table('products')
    ->where($condicoes)
    ->count();

    if($qtd_produtos < 8){
      return 1;
    }
    else{
      $resto = $qtd_produtos%8;
      $qtd_paginas = ($qtd_produtos - $resto)/8;
      if($resto > 0){
        $qtd_paginas++;
      }
      return $qtd_paginas;
    }
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
  public static function getProducts($condicoes, $genero, $page=1){
    $page = ($page - 1) * 8;
    $skip = false;

    switch($genero){
      case 'meninos':
        $condicoes[] = ['gender', '=' , 'meninos'];
        break;
      case 'meninas':
        $condicoes[] = ['gender', '=', 'meninas'];
        break;
      case 'unisex':
        $produtos = DB::table('products')
        ->join('brands', 'brands.id', 'products.brand_id')
        ->join('product_images', 'product_images.product_id', '=', 'products.id')
        ->select('products.id', 'products.name', 'products.description',
        'products.gender', 'products.quality', 'products.price', 'products.original_price',
        'products.discount', 'brands.name as brand', 'product_images.filename as imagem', 'products.unique_id')
        ->orderBy('created_at')
        ->skip($page)
        ->take(8)
        ->where($condicoes)
        ->where('product_images.type', '=', 'profile')
        ->whereIn('gender', ['meninas', 'meninos'])
        ->get();
        $skip = true;
        break;
      case 'papai':
        $condicoes[] = ['gender', '=', 'papai'];
        break;
      case 'mamae':
        $condicoes[] = ['gender', '=', 'mamae'];
        break;
      default:
        break;
    }

    if($skip == false){
      $produtos = DB::table('products')
      ->join('brands', 'brands.id', 'products.brand_id')
      ->join('product_images', 'product_images.product_id', '=', 'products.id')
      ->select('products.id', 'products.name', 'products.description',
      'products.gender', 'products.quality', 'products.price', 'products.original_price',
      'products.discount', 'brands.name as brand', 'product_images.filename as imagem', 'products.unique_id')
      ->orderBy('created_at')
      ->skip($page)
      ->take(8)
      ->where($condicoes)
      ->where('product_images.type', '=', 'profile')
      ->get();
    }

    if(count($produtos) > 0){
      for($i=0;$i < sizeof($produtos)-1;$i++){
        if($produtos[$i]->id == $produtos[$i+1]->id){
          unset($produtos[$i+1]);
        }
      }

      return $produtos;
    }else{
      return null;
    }
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
