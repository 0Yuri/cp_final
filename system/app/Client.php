<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\User;
use App\Client;
use App\Address;

class Client extends Model
{
  const TABLE_NAME = "moip_clients";

  // Pega o ID do cliente moip através do id do usuário
  public static function getClientId($id){
    $customer_id = DB::table(self::TABLE_NAME)
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
    $data = array(
      'user_id' => $user_id,
      'client_id' => $client_id
    );
    $inseriu = DB::table(self::TABLE_NAME)
    ->insert($data);

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
    ->select('name as nome', '.last_name as sobrenome', 'email', 'birthdate as aniversario', 'cpf as cpf', 'rg', 
    'issuer as emissor', 'issue_date as data_emissao', 'ddd_1 as ddd', 'tel_1 as telefone', 'id',
      // Endereço
      'street as rua' , 'number as numero', 'neighborhood as bairro', 'city as cidade',
      'uf as estado', 'complement as complemento', 'cep')
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
