<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\User;
use App\Store;
use App\Product;
use DateTime;


class Question extends Model
{

  const TABLE_NAME = "questions";

  // Realizar uma pergunta
  public static function ask($produto, $pergunta, $id){

    $store_id = Product::pegarID($produto);
    if($store_id == null){
      return false;
    }

    $owner = Store::getOwnerOfStore($store_id);
    if($owner == null){
      return false;
    }
    
    $question = array(
      'unique_id' => uniqid("QUEST-"),
      'product_id' => $produto,
      'store_owner' => $owner['id'],
      'ask_id' => $id,
      'question' => $pergunta
    );

    $inseriu = DB::table(Question::TABLE_NAME)->insert($question);

    if($inseriu){
      return true;
    }else{
      return false;
    }
  }

  // Responder uma pergunta
  public static function answer($resposta, $unique_id){

    $respondeu = DB::table(Question::TABLE_NAME)
    ->where('unique_id', $unique_id)
    ->update(['answer' => $resposta, 'status' => 'respondida']);

    if($respondeu){
      return true;
    }
    else{
      return false;
    }
  }

  // Pegar as perguntas de um produto pelo seu id
  public static function getQuestions($id){
    $perguntas = DB::table(Product::TABLE_NAME)
    ->select('questions.*')
    ->join(Question::TABLE_NAME, 'questions.product_id', '=', 'products.id')
    ->where('products.id', '=', $id)
    ->get();

    return $perguntas;
  }

  public static function deleteQuestion($question_id, $user_id){
    $pergunta = DB::table(Question::TABLE_NAME)
    ->where(Question::TABLE_NAME . '.unique_id', '=', $question_id)
    ->get();

    if(count($pergunta) > 0){
      $pergunta = $pergunta[0];
      if($pergunta->ask_id == $user_id){
        $deletado = DB::table(Question::TABLE_NAME)
        ->where(Question::TABLE_NAME . '.unique_id', $question_id)
        ->delete();
      }
      else if($pergunta->store_owner == $user_id){
        $deletado = DB::table(Question::TABLE_NAME)
        ->where(Question::TABLE_NAME . '.unique_id', $question_id)
        ->delete();
      }
      else{
        $deletado = false;
      }

      if($deletado){
        return true;
      }
      else{
        return false;
      }
    }
    else{
      return false;
    }
  }

  // Pegar pergunta por id
  public static function getQuestion($unique_id){
    $pergunta = DB::table(Question::TABLE_NAME)
    ->select(Question::TABLE_NAME . '.question', Question::TABLE_NAME . '.unique_id', Question::TABLE_NAME . '.product_id')
    ->where('unique_id', $unique_id)
    ->where('status', "criada")
    ->get();

    if(count($pergunta) > 0){
      return $pergunta[0];
    }
    else{
      return null;
    }
  }

  public static function getQuestionX($unique_id){
    $pergunta = DB::table(Question::TABLE_NAME)
    ->select(Question::TABLE_NAME . '.question', Question::TABLE_NAME . '.unique_id', Question::TABLE_NAME . '.product_id')
    ->where('unique_id', $unique_id)
    ->get();

    if(count($pergunta) > 0){
      return (array)$pergunta[0];
    }
    else{
      return null;
    }
  }

  // Pegar perguntas ativas(n respondidas)
  public static function getActiveOnes($id, $page = 0, $take = 8){
    $perguntas = DB::table(Store::TABLE_NAME)
    ->join(Product::TABLE_NAME, 'products.store_id', '=', 'stores.id')
    ->join(Question::TABLE_NAME, 'questions.product_id', '=', 'products.id')
    ->join(User::TABLE_NAME, 'users.id', '=', 'questions.ask_id')
    ->select('questions.unique_id', 'stores.name as loja', 'questions.created_at as data', 'products.name as produto', 'questions.question as pergunta', 'users.name as nome', 'users.last_name as sobrenome')
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

  public static function getPageCount($id, $take = 8){
    $qtd = DB::table(Store::TABLE_NAME)
    ->join(Product::TABLE_NAME, 'products.store_id', '=', 'stores.id')
    ->join(Question::TABLE_NAME, 'questions.product_id', '=', 'products.id')
    ->join(User::TABLE_NAME, 'users.id', '=', 'questions.ask_id')
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
