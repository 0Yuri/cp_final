<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Product;
use DB;

class QuestionController extends Controller
{

  public function perguntar(){
    $this->isLogged();
    $data = $this->get_post();

    $produto = $data['produto'];

    $produto_id = DB::table('products')
    ->select('id')
    ->where('unique_id', $produto->unique_id)
    ->get();

    if(count($produto_id) > 0){
      $produto_id = $produto_id[0]->id;

      if($this->isMeuProduto($produto->unique_id, $_SESSION['user_id'])){
        $this->return->setFailed("Você não pode perguntar neste produto.");
        return;
      }

      $question = $data['pergunta']->content;

      $inserir = Question::perguntar($produto_id, $question, $_SESSION['user_id']);

      if(!$inserir){
        $this->return->setFailed("Falha ao realizar pergunta.");
        return;
      }

    }
    else{
      $this->return->setFailed("Nenhum produto foi encontrado com esse identificador.");
      return;
    }
  }

  public function responder(){
    $data = $this->get_post();

    $responder = Question::responder($data['answer'], $data['id']);

    if(!$responder){
      $this->return->setFailed("Erro ao responder pergunta.");
      return;
    }
  }

  public function pegarPerguntas(){
    $data = $this->get_post();

    $produto = DB::table('products')
    ->select('id')
    ->where('unique_id', $data['unique_id'])
    ->get();

    if(count($produto) > 0){
      $produto = $produto[0];
      $perguntas = Question::pegarPerguntas($produto->id);

      $this->return->setObject($perguntas);
      return;
      
    }
    else{
      $this->return->setFailed("Nenhum produto foi encontrado.");
      return;
    }

  }

  public function pegarPergunta(){
    $data = $this->get_post();

    if(is_null($data)){
      $this->return->setFailed("Data not set.");
      return;
    }

    $pergunta = Question::pegarPergunta($data['id']);

    if($pergunta == null){
      $this->return->setObject("ERRO");
      $this->return->setFailed("Nenhuma pergunta foi encontrada.");
      return;
    }
    else{
      $this->return->setObject($pergunta);
    }
  }

  public function perguntasAtivas(){
    $data = $this->get_post();

    if(isset($data['page']) && strlen($data['page']) > 0){
      $page = $data['page'];
    }
    else{
      $page = 0;
    }

    $perguntas = Question::pegarAtivas($_SESSION['user_id'], $page);

    if(count($perguntas) <= 0){
      $this->return->setFailed("Nenhuma pergunta foi encontrada.");
    }

    $paginas = Question::pegarPaginas($_SESSION['user_id']);

    $this->return->setObject(array(
      'perguntas' => $perguntas,
      'paginas' => $paginas
    ));

  }

  private function isMeuProduto($id, $user_id){
    $produto = DB::table('stores')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->where('stores.owner_id', '=', $user_id)
    ->where('products.unique_id', '=', $id)
    ->get();

    if(count($produto) > 0){
      return true;
    }
    else{
      return false;
    }
  }


}