<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Address;

class SignupController extends Controller
{
    // Primeiro passo do cadastro - Verificação de email
  public function signupEmailInfo(){
    $data = $this->get_post();    

    if(isset($_SESSION['new_user'])){
      $_SESSION['new_user'] = array();
    }

    $status_email = User::doesEmailExists($data['email']);

    if($status_email){
      $this->return->setFailed("Email inválido ou já está em uso.");
      return;
    }
    else{
      $_SESSION['new_user'] = array();
      $_SESSION['new_user']['email'] = $data['email'];
    }
  }

  // Segundo passo do cadastro - Informações Pessoais
  public function signupPersonalInfo(){
    $data = $this->get_post();

    if($data == null || !isset($_SESSION['new_user']['email']) || $_SESSION['new_user']['email'] == null ){
      $this->return->setFailed("Erro no processo de cadastro.");
      return;
    }

    $_SESSION['new_user']['personal_info'] = $data;
  }

  // Terceiro passo do cadastro - Informações de Endereços
  public function signupAddressInfo(){
    $data = $this->get_post();

    if($data == null || !isset($_SESSION['new_user']['personal_info']) || $_SESSION['new_user']['personal_info'] == null){
      $this->return->setFailed("Erro no processo de cadastro.");
      return;
    }

    $_SESSION['new_user']['address_info'] = $data;
  }

  // Quarto passo do cadastro - Informações do Moip
  public function signupMoipInfo(){
    $data = $this->get_post();
  }

  public function debugSignup(){
    if(isset($_SESSION['new_user'])){
      $this->return->setObject($_SESSION['new_user']);
    }
    else{
      $this->return->setFailed("Nada na sessão.");
    }
  }
}
