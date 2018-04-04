<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Moip\Moip;
use App\Account;
use App\Conta;
use DB;

class MoipAccount extends Model
{

  // Cria uma conta moip, depois salva no banco de dados
  public function criarConta(Moip $moip, $id){
    // Retorna um objeto através do ID do usuário no formato esperado para cadastrar a conta.
    $data = Account::objetoConta($id);

    if ($data == null){
      exit();
    }

    try{
      $account = $moip->accounts()
      ->setName($data['nome'])
      ->setLastName($data['sobrenome'])
      ->setEmail($data['email'])
      ->setIdentityDocument($data['rg'], $data['emissor'], $data['data_emissao'])
      ->setBirthDate($data['aniversario'])
      ->setTaxDocument($data['cpf'])
      ->setType('MERCHANT')
      ->setPhone($data['ddd'], $data['telefone'], 55)
      ->addAddress($data['rua'], $data['numero'], $data['bairro'],
       $data['cidade'], $data['estado'], $data['cep'], $data['complemento'], 'BRA')
      ->setTransparentAccount(true)
      ->create();
      $account_id = $account->getId();
      $user_id = $data['id'];
      $access_token = $account->getAccessToken();
      // Salva a conta no banco de dados
      $status = Account::add($account_id, $user_id, $access_token);
      return $status;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401
      echo $e->getMessage();
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
      echo $e->getMessage();
    }
    return false;

  }

  // Pega o ID da conta moip através do id da loja
  public static function getAccountId($store_id){
    $id = DB::table('stores')
    ->select('moip_accounts.account_id')
    ->join('moip_accounts', 'stores.owner_id', '=', 'moip_accounts.user_id')
    ->where('stores.id', $store_id)
    ->get();


    if(count($id) > 0){
      return $id[0]->account_id;
    }
    else{
      return null;
    }
  }

  public static function getAccessToken($id){
    $id = DB::table('moip_accounts')
    ->select('accessToken')
    ->where('user_id', $id)
    ->get();

    if(count($id) > 0){
      $id = $id[0];
      return $id->accessToken;
    }
    else{
      return null;
    }
  }

  public static function getSellerToken($id){
    $token = DB::table('stores')
    ->join('users', 'users.id', '=', 'stores.owner_id')
    ->join('moip_accounts', 'moip_accounts.user_id', '=', 'users.id')
    ->where('stores.id', '=', $id)
    ->get();

    if(count($token) > 0){
      return $token[0]->accessToken;
    }
    else{
      return null;
    }
  }

  public static function getAuthorizationBearer($id){
    $id = DB::table('moip_accounts')
    ->select('accessToken')
    ->where('user_id', $id)
    ->get();

    if(count($id) > 0){
      $id = $id[0];
      $string = "Authorization: Bearer " . $id->accessToken;
      return $string;
    }
    else{
      return null;
    }
  }

  public static function getSellerID($id){
    $id = DB::table('moip_accounts')
    ->select('account_id')
    ->where('user_id', $id)
    ->get();

    if(count($id) > 0){
      return $id[0]->account_id;
    }
    else{
      return null;
    }
  }

}
