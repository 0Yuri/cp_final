<?php

namespace App\Http\Controllers;

use DB;
use App\Contatos;


class ContactController extends Controller
{
  public function fale_conosco(){
    $data = $this->get_post();

    $adicionou = Contatos::salvar($data);

    if(!$adicionou){
      $this->return->setFailed("Erro ao enviar mensagem.");
      return;
    }
  }

}
