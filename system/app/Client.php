<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\User;
use App\Client;
use App\Address;

class Client extends Model
{
  const TABLE_NAME = "moip_accounts";

  // Pega o ID do cliente moip através do id do usuário
  public static function getClientId($id){
    $customer_id = DB::table(Client::TABLE_NAME)
    ->select('client_id')
    ->where('user_id', $id)
    ->get();

    if(count($customer_id) > 0){
      return $customer_id[0]->client_id;
    }
    else{
      return null;
    }
  }

  // Salva o cliente no banco de dados
  public static function add($user_id, $client_id){
    $inseriu = DB::table(Client::TABLE_NAME)
    ->where('user_id', $user_id)
    ->update(['client_id' => $client_id]);

    if($inseriu){
      return true;
    }
    else{
      return false;
    }
  }

  // Cria um objeto no formato do cliente
  public static function objetoCliente($user_id){
    $cliente = DB::table(User::TABLE_NAME)
    ->select(
      User::TABLE_NAME . '.name as nome', User::TABLE_NAME . '.last_name as sobrenome', User::TABLE_NAME . '.email',
      User::TABLE_NAME . '.birthdate as aniversario', User::TABLE_NAME . '.cpf as cpf', User::TABLE_NAME . '.rg',
      User::TABLE_NAME . '.issuer as emissor', User::TABLE_NAME . '.issue_date as data_emissao',
      User::TABLE_NAME . '.ddd_1 as ddd', User::TABLE_NAME . '.tel_1 as telefone', User::TABLE_NAME . '.id as id',
      // Endereço
      Address::TABLE_NAME . '.street as rua' , Address::TABLE_NAME . '.number as numero',
      Address::TABLE_NAME . '.neighborhood as bairro', Address::TABLE_NAME . '.city as cidade',
      Address::TABLE_NAME . '.uf as estado', Address::TABLE_NAME . '.complement as complemento',
      Address::TABLE_NAME . '.cep')
      ->join(Address::TABLE_NAME, Address::TABLE_NAME . '.user_id', User::TABLE_NAME . '.id')
      ->where(User::TABLE_NAME . '.id', $user_id)
      ->get();

      if(count($cliente) > 0){
        return (array)$cliente[0];
      }
      else{
        return null;
      }
  }
}
