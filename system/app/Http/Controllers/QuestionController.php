<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Store;
use App\Product;
use DB;

class QuestionController extends Controller
{

  const ERROR_MSG = "Ocorreu um erro ao realizar a sua pergunta.";
  const CANNOT_ASK_MSH = "Você não pode perguntar neste produto.";

  public function ask(){
    $this->isLogged();
    $data = $this->get_post();

    $pergunta = $data['pergunta']->content;
    $produto_id = $data['produto']->unique_id;

    $produto = Product::getProductByUnique($produto_id);

    if($produto == null){
      $this->return->setFailed(QuestionController::ERROR_MSG);
      return;
    }

    $dono_do_produto = Store::getOwnerOfStore($produto['store_id']);

    $dono_do_produto = $dono_do_produto['id'];

    if($dono_do_produto == null){
      $this->return->setFailed(QuestionController::ERROR_MSG);
      return;
    }

    if($this->isMyProduct($produto_id, $_SESSION['user_id'])){
      $this->return->setFailed(QuestionController::CANNOT_ASK_MSH);
      return;
    }

    $inserir = Question::ask($_SESSION['user_id'], $dono_do_produto, $produto, $pergunta);

    if(strlen($inserir) > 0){
      $this->return->setFailed($inserir);
      return;
    }
  }

  public function answer(){
    $data = $this->get_post();

    $responder = Question::answer($data['answer'], $data['unique_id']);

    if(!$responder){
      $this->return->setFailed("Erro ao responder pergunta.");
      return;
    }
  }

  public function removeQuestion(){
    $this->isLogged();
    $data = $this->get_post();
    $pergunta_id = $data['unique_id'];

    $deletar = Question::deleteQuestion($pergunta_id, $_SESSION['user_id']);

    if(!$deletar){
      $this->return->setFailed("Não foi possível remover esta pergunta.");
      return;
    }
  }

  public function getQuestions(){
    $data = $this->get_post();

    $produto = DB::table('products')
    ->select('id')
    ->where('unique_id', $data['unique_id'])
    ->get();

    if(count($produto) > 0){
      $produto = $produto[0];
      $perguntas = Question::getQuestions($produto->id);

      $this->return->setObject($perguntas);
      return;
      
    }
    else{
      $this->return->setFailed("Nenhum produto foi encontrado.");
      return;
    }

  }

  public function getQuestion(){
    $data = $this->get_post();

    if(is_null($data)){
      $this->return->setFailed("Data not set.");
      return;
    }

    $pergunta = Question::getQuestion($data['unique_id']);

    if($pergunta == null){
      $this->return->setObject("ERRO");
      $this->return->setFailed("Nenhuma pergunta foi encontrada.");
      return;
    }
    else{
      $this->return->setObject($pergunta);
    }
  }

  public function getActiveQuestions(){
    $data = $this->get_post();

    if(isset($data['page']) && strlen($data['page']) > 0){
      $page = $data['page'];
    }
    else{
      $page = 0;
    }

    $perguntas = Question::getActiveOnes($_SESSION['user_id'], $page);

    if(count($perguntas) <= 0){
      $this->return->setFailed("Nenhuma pergunta foi encontrada.");
    }

    $paginas = Question::getPageCount($_SESSION['user_id']);

    $this->return->setObject(array(
      'perguntas' => $perguntas,
      'paginas' => $paginas
    ));

  }

  private function isMyProduct($id, $user_id){
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
