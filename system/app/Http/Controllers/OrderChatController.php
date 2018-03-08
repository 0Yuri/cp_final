<?php

namespace App\Http\Controllers;

use DB;

class OrderChatController extends Controller
{
  public function getChat(){
    $data = $this->get_post();

    $chat_messages = DB::table('orders_chat')
    ->join('users', 'users.id', '=', 'orders_chat.writer_id')
    ->select('orders_chat.*', 'users.name')
    ->where('unique_id', $data['id'])
    ->get();

    if(count($chat_messages) > 0){
      $this->return->setObject($chat_messages);
      return;
    }
    else{
      $this->return->setFailed("Nenhuma mensagem foi enviada neste chat.");
      return;
    }
  }

  private function getMessages($order_id){
  }

  public function write(){
    $this->isLogged();
    $data = $this->get_post();

    $message = array(
      'writer_id' => $_SESSION['user_id'],
      'unique_id' => $data['order']->id,
      'content' => $data['info']->content,
    );

    $inserir = DB::table('orders_chat')
    ->insert($message);

    if($inserir){
      return;
    }
    else{
      $this->return->setFailed("Ocorreu um erro ao enviar esta mensagem.");
      return;
    }
  }
}
