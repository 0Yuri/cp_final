<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favoritos extends Model
{
  // Salva um novo item como favorito
  public static function salvarFavorito($data){

    $adicionou = DB::table('favorites')
    ->insert($data);

    if($adicionou){
      return true;
    }else{
      return false;
    }
  }

  // Remove um item como favorito
  public static function removerFavorito($id){
    $removeu = DB::table('favorites')
    ->where('product_id', $id)
    ->where('user_id', $_SESSION['user_id'])
    ->delete();

    if($removeu){
      return true;
    }else{
      return false;
    }

  }

  // Verifica se um item já é seu favorito
  public static function existeFavorito($id, $product){
    $existe = DB::table('favorites')
    ->select('*')
    ->where('favorites.user_id', $id)
    ->where('favorites.product_id', $product)
    ->get();

    if(count($existe) > 0){
      return true;
    }else{
      return false;
    }
  }

  // Pega seus favoritos
  public static function pegarFavoritos($id, $page = 0){
    $take = 8;

    // Calcula a quantidade de páginas
    $qtd_favoritos = DB::table('favorites')
    ->join('products', 'products.id', '=', 'favorites.product_id')
    ->where('favorites.user_id', $id)
    ->count();

    if($qtd_favoritos < $take){
      $qtd_paginas = 0;
    }
    else{
      $resto = $qtd_favoritos%$take;

      $qtd_paginas = ($qtd_favoritos - $resto)/$take;

      if($resto > 0){
        $qtd_paginas++;
      }
    }

    if($page < 0){
      $page = 0;
    }
    else if($page > ($qtd_paginas - 1)){
      $page = $qtd_paginas - 1;
    }

    $favoritos = DB::table('favorites')
    ->join('products', 'products.id', '=', 'favorites.product_id')
    ->select('products.name', 'products.id', 'products.unique_id')
    ->where('favorites.user_id', $id)
    ->skip($page * $take)
    ->take($take)
    ->get();

    if(count($favoritos) <= 0){
      return array(
        'favoritos' => null,
        'paginas' => 0
      );
    }
    else{
      return array(
        'favoritos' => $favoritos,
        'paginas' => $qtd_paginas
      );
    }

  }
}
