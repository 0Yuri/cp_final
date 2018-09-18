<?php

namespace App\Http\Controllers;

use Moip\Moip;
use Moip\Auth\OAuth;

use App\User;
use App\Client;
use App\CPF;
use App\Activation;
use App\Validation;

use App\MoipClient;
use App\MoipAccount;
use App\Moip as MoipConstants;

use DB;

class UserController extends Controller
{
  protected $access_token = MoipConstants::ACCESS_TOKEN;
  protected $moip;

  public function __construct(){
    parent::__construct();
    $this->moip = new Moip(new OAuth($this->access_token), Moip::ENDPOINT_PRODUCTION);
  }

  // Cadastro de novo usuario
  public function signup(){
    $data = $this->get_post();
    $data = (array) $data;   

    // Validar confirmar senha e depois removê-lo
    if(!User::validate_password($data['password'], $data['confirmpassword'])){
      $this->return->setFailed("Senhas não são iguais.");
      return;
    }
    else{
      unset($data['confirmpassword']);
    }

    // Verificar se o email já é cadastrado.
    if(User::doesEmailExists($data['email'])){
      $this->return->setFailed("Ocorreu um erro ao realizar o cadastro, esse email já foi cadastrado.");
      return;
    }
    // Verifica se o CPF é válido
    $isCpfValid = CPF::validate($data['cpf']);    
    if(!$isCpfValid){
      $this->return->setFailed("O CPF inserido é inválido.");
      return; 
    }

    // Inverter as datas para o formato correto de DD-MM-YYYY para YYYY-MM-DD
    $data['birthdate'] = $this->transformDate($data['birthdate']);
    $data['issue_date'] = $this->transformDate($data['issue_date']); 

    // Cria o cliente Moip
    $clienteMoip = MoipClient::criarCliente($this->moip, $data);
    if($clienteMoip == null){
      $this->return->setFailed("Dados inconsistentes para criação de perfil cliente.");
      return;
    }

    // Cria o usuário na base caso esteja tudo okay.
    do{
      $name_id = uniqid($data['name']);
      $name_id = str_ireplace(" ", "", $name_id);
    }
    while(User::isNameIdInUse($name_id));
    // Define o name_id único e o torna lowercase
    $data['name_id'] = strtolower($name_id);      

    // Adiciona o usuário no banco de dados
    $inseriu = User::add($data);

    // Se não inseriu, retornar error
    if($inseriu < 0){
      $this->return->setFailed("Ocorreu um erro ao tentar cadastrar.");
      return;
    }
    // Moip Related
    else{
      // Criar o cliente
      $status = Client::add($inseriu, $clienteMoip->getId());

      if(!$status){
        $this->return->setFailed("Ocorreu um erro ao cadastrar sua conta.");
        return;
      }
    }

    // Geração de token para ativação
    if(!Activation::generateActivationToken($inseriu, $data['email'], $data['name'])){
      $this->return->setFailed("Ocorreu um erro ao gerar seu link de  ativação.");
      return;
    }
  }

  // Atualizar cadastro
  public function update(){
    $data = $this->get_post();
    $data['birthdate'] = $this->transformDate($data['birthdate']);

    $alterou = User::updateUser($data);

    if(!$alterou){
      $this->return->setFailed("Ocorreu um erro ao alterar o seu cadastro.");
    }
  }

  public function activateAccount(){
    $data = $this->get_post();
    $token = $data['token'];

    if(strlen($token) <= 0){
      $this->return->setFailed("Token inválido, ocorreu um erro no envio do token de ativação, tente novamente!");
      return;
    }

    $ativado = Activation::activate($token);

    if(!$ativado){
      $this->return->setFailed("Ocorreu um erro ao ativar sua conta, tente novamente!");
      return;
    }
  }

  // Pegar usuário X
  public function getUser(){
    $data = $this->get_post();

    $usuario = User::grabUserById($data['id']);

    if($usuario == null){
      $this->return->setFailed("Nenhum usuário encontrado com este identificador.");
      exit();
    }else{
      $this->return->setObject($usuario);
    }
  }

  // Converte a data introduzida para o formato do banco de dados
  // Formato YYYY-mm-dd
  private function transformDate($string){
    $data = explode("-", $string);
    $d = mktime(0,0,0, $data[1], $data[0], $data[2]);
    $data = date("Y-m-d", $d);
    return $data;
  }
  
  public function admin(){
    $this->isLogged();
    $status = Validation::validateAdmin($_SESSION['user_id']);

    if($status){
      return;
    }
    else{
      $this->return->setFailed("Operação inválida.");
      return;
    }
  }
}
