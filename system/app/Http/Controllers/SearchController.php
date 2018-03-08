<?php

namespace App\Http\Controllers;
use DB;

class SearchController extends Controller
{
  function pesquisar(){
    $data = $this->get_post();
    $resultado = array(
      'products' => array(
        'success' => false,
        'results' => array()
      ),
      'stores' => array(
        'success' => false,
        'results' => array()
      )
    );

    // Verifica se nada foi digitado
    if(count($data) <= 0){
      $this->return->setFailed("Não foi possível realizar a pesquisa. Falta uma palavra chave");
      return;
    }

    // Consulta produtos
    $products = DB::table('products')
    ->select('products.id', 'products.name', 'products.gender', 'products.discount', 'products.unique_id')
    ->where('name' , 'like', "%".$data['pesquisa']."%")
    ->get();

    if(count($products) > 0){
      $resultado['products']['success'] = true;
      $resultado['products']['results'] = $products;
    }

    // Consulta Lojas
    $stores = DB::table('stores')
    ->select('stores.id', 'stores.name', 'stores.unique_id')
    ->where('name', 'like', "%".$data['pesquisa']."%")
    ->where('status', 'ativado')
    ->get();

    if(count($stores) > 0){
      $resultado['stores']['success'] = true;
      $resultado['stores']['results'] = $stores;
    }

    $this->return->setObject($resultado);
  }
}
