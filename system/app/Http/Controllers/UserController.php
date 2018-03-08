<?php

namespace App\Http\Controllers;

use DB;
use Moip\Moip;
use Moip\Auth\OAuth;
use App\User;
use App\CPF;
use App\Validation;
use App\MoipClient;
use App\MoipAccount;

class UserController extends Controller
{
  protected $access_token = "a4face756e9e4e5c977b0b6449d4e168_v2";
  protected $moip;

  // Cadastro de novo usuario
  public function signup(){
    $data = $this->get_post();

    $this->moip = new Moip(new OAuth($this->access_token), Moip::ENDPOINT_SANDBOX);

    // Validar confirmar senha e depois removê-lo
    if(!User::validar_senha($data['user_info']->password, $data['user_info']->confirmpassword)){
      $this->return->setFailed("Senhas não são iguais.");
      return;
    }
    else{
      unset($data['user_info']->confirmpassword);
    }

    // Verificar se o email já é cadastrado.
    if(User::existe($data['user_info']->email)){
      $this->return->setFailed("Ocorreu um erro ao realizar o cadastro, esse email já foi cadastrado.");
      return;
    }

    // Criar o name_id e fica gerando caso já exista
    do{
      $name_id = uniqid($data['user_info']->name);
      $name_id = str_ireplace(" ", "", $name_id);
      User::existeNameID($name_id);
    }
    while(User::existeNameID($name_id));

    $data['user_info']->name_id = $name_id;

    // Inverter as datas para o formato correto de DD-MM-YYYY para YYYY-MM-DD
    $data['user_info']->birthdate = $this->converterData($data['user_info']->birthdate);
    $data['user_info']->issue_date = $this->converterData($data['user_info']->issue_date);

    $isCpfValid = CPF::validate($data['user_info']->cpf);

    // Salvar no banco de dados

    if($isCpfValid){
      // TODO: Hashear a senha
      $inseriu = User::salvar($data);
    }
    else{
      $this->return->setFailed("CPF inválido.");
      return;
    }
    // Se não inseriu, retornar error
    if($inseriu < 0){
      $this->return->setFailed("Ocorreu um erro ao tentar cadastrar.");
      return;
    }
    else{
      $moip_account = new MoipAccount();
      $accessToken = $moip_account->criarConta($this->moip, $inseriu);

      $moip_client = new MoipClient();
      $status = $moip_client->criarCliente($this->moip, $inseriu);

    }
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

  // Atualizar cadastro
  public function update(){
    $data = $this->get_post();

    $data['birthdate'] = $this->converterData($data['birthdate']);

    $alterou = User::alterar($data);

    if(!$alterou){
      $this->return->setFailed("Ocorreu um erro ao alterar o seu cadastro.");
    }
  }

  // Pegar usuário X
  public function getUser(){
    $data = $this->get_post();

    $usuario = User::pegarUsuario($data['id']);

    if($usuario == null){
      $this->return->setFailed("Nenhum usuário encontrado com este identificador.");
      exit();
    }else{
      $this->return->setObject($usuario);
    }

  }


  // TODO: Não lembro qual a funcao
  public function destinatario($id){
    if($id != null){
      $usuario = DB::table('users')
      ->select('name_id', 'name', 'last_name')
      ->where('name_id', $id)
      ->get();

      if(count($usuario) > 0){
        $usuario = $usuario[0];
        $this->return->setObject($usuario);
        return;
      }
      else{
        $this->return->setFailed("Nenhum destinatário foi encontrado.");
        return;
      }
    }
    else{
      $this->return->setFailed("Nenhum destinatário foi encontrado.");
      return;
    }
  }

  // Converte a data introduzida para o formato do banco de dados
  private function converterData($string){
    $data = explode("-", $string);
    $d = mktime(0,0,0, $data[1], $data[0], $data[2]);
    $data = date("Y-m-d", $d);
    return $data;
  }


}
