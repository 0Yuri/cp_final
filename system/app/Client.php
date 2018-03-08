<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Client extends Model
{
  // Pega o ID do cliente moip através do id do usuário
  public static function getClientId($id){
    $customer_id = DB::table('moip_accounts')
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
  public static function salvarCliente($user_id, $client_id){
    $inseriu = DB::table('moip_accounts')
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
  public static function objetoCliente($id){
    $cliente = DB::table('users')
    ->select(
      'users.name as nome', 'users.last_name as sobrenome', 'users.email',
      'users.birthdate as aniversario', 'users.cpf as cpf', 'users.rg',
      'users.issuer as emissor', 'users.issue_date as data_emissao',
      'users.ddd_1 as ddd', 'users.tel_1 as telefone', 'users.id as id',
      // Endereço
      'address.street as rua' , 'address.number as numero',
      'address.neighborhood as bairro', 'address.city as cidade',
      'address.uf as estado', 'address.complement as complemento',
      'address.cep')
      ->join('address', 'address.user_id', 'users.id')
      ->where('users.id', $id)
      ->get();

      if(count($cliente) > 0){
        return (array)$cliente[0];
      }
      else{
        return null;
      }
  }
}
