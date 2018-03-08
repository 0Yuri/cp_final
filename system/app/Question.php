<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Question extends Model
{

  // Realizar uma pergunta
  public static function perguntar($produto, $pergunta, $id){
    $question = array(
      'product_id' => $produto,
      'ask_id' => $id,
      'question' => $pergunta
    );

    $inseriu = DB::table('questions')->insert($question);

    if($inseriu){
      return true;
    }else{
      return false;
    }
  }

  // Responder uma pergunta
  public static function responder($resposta, $id){

    $respondeu = DB::table('questions')
    ->where('id', $id)
    ->update(['answer' => $resposta, 'status' => 'respondida']);

    if($respondeu){
      return true;
    }
    else{
      return false;
    }
  }

  // Pegar as perguntas de um produto pelo seu nome
  public static function pegarPerguntas($id){
    $perguntas = DB::table('products')
    ->select('questions.*')
    ->join('questions', 'questions.product_id', '=', 'products.id')
    ->where('products.id', '=', $id)
    ->get();

    return $perguntas;
  }

  // Pegar pergunta por id
  public static function pegarPergunta($id){
    $pergunta = DB::table('questions')
    ->select('*')
    ->where('id', $id)
    // ->where('status', 'criada')
    ->get();

    if(count($pergunta) > 0){
      return $pergunta[0];
    }
    else{
      return null;
    }
  }

  // Pegar perguntas ativas(n respondidas)
  public static function pegarAtivas($id, $page = 0, $take = 8){
    $perguntas = DB::table('stores')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->join('questions', 'questions.product_id', '=', 'products.id')
    ->join('users', 'users.id', '=', 'questions.ask_id')
    ->select('questions.id as id', 'stores.name as loja', 'questions.created_at as data', 'products.name as produto', 'questions.question as pergunta', 'users.name as nome', 'users.last_name as sobrenome')
    ->where('stores.owner_id', $id)
    ->where('questions.status', 'criada')
    ->skip($page * $take)
    ->take($take)
    ->get();

    if(count($perguntas) >= 0){
      return $perguntas;
    }else{
      return null;
    }
  }

  public static function pegarPaginas($id, $take = 8){
    $qtd = DB::table('stores')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->join('questions', 'questions.product_id', '=', 'products.id')
    ->join('users', 'users.id', '=', 'questions.ask_id')
    ->where('stores.owner_id', $id)
    ->where('questions.status', 'criada')
    ->count();

    if($qtd < $take){
      return 0;
    }
    else{
      $resto = $qtd%$take;
      $qtd_paginas = ($qtd - $resto)/$take;

      if($resto > 0){
        $qtd_paginas++;
      }

      return $qtd_paginas;
    }
  }

}
