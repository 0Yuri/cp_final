<?php

namespace App\Http\Controllers;

use DB;
use App\SentMessages;
use App\ReceivedMessages;

class MessageController extends Controller
{

  public function __construct(){
    parent::__construct();
    $this->isLogged();
  }

  public function enviadas(){
    $data = $this->get_post();
    $page = 0;

    // Caso nenhuma pagina de exibicao seja enviada
    if(isset($data['page']) && strlen($data['page']) > 0){
      $page = $data['page'];
    }

    // Pega as mensagens
    $mensagens = SentMessages::get($_SESSION['user_id'], $page);
    // Pega quantidade de paginas
    $paginas = SentMessages::getPages($_SESSION['user_id']);

    $retorno = array(
      'paginas' => $paginas,
      'mensagens' => $mensagens
    );

    $this->return->setObject($retorno);

    if($mensagens == null){
      $this->return->setFailed("Nenhuma mensagem foi enviada.");
    }

  }

  public function recebidas(){
    $data = $this->get_post();
    $page = 0;

    // Caso nenhuma pagina de exibicao seja enviada
    if(isset($data['page']) && strlen($data['page']) > 0){
      $page = $data['page'];
    }

    // Pega as mensagens
    $mensagens = ReceivedMessages::get($_SESSION['user_id'], $page);

    // Pega quantidade de paginas
    $paginas = ReceivedMessages::getPages($_SESSION['user_id']);

    $retorno = array(
      'paginas' => $paginas,
      'mensagens' => $mensagens
    );

    $this->return->setObject($retorno);

    if($mensagens == null){
      $this->return->setFailed("Nenhuma mensagem foi recebida.");
    }
  }

  public function pegarMensagem(){
    $data = $this->get_post();

    $mensagem = DB::table('messages')
    ->select('messages.*', 'users.name' , 'users.last_name')
    ->where('destiny_id', $_SESSION['user_id'])
    ->join('users', 'users.id', '=', 'messages.writer_id')
    ->get();

    if(count($mensagem) > 0){
      $this->return->setObject($mensagem[0]);
      return;
    }
    else{
      $this->return->setFailed("Nenhuma mensagem foi encontrada.");
    }
  }

  public function escrever(){
    $data = $this->get_post();
    print_r($data);
  }

  public function responder(){
    $data = $this->get_post();
    print_r($data);
  }

  public function apagarMensagem(){
    $data = $this->get_post();
  }
}
