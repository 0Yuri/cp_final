<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Account extends Model
{
  const TABLE_NAME = "moip_accounts";

  // Salva a conta no banco de dados
  public static function add($account_id, $user_id, $token){
    if($account_id == null | $user_id == null | $token == null){
      return null;
    }
    else{
      $objeto = array(
        'user_id' => $user_id,
        'account_id' => $account_id,
        'accessToken' => $token
      );

      $inseriu = DB::table(self::TABLE_NAME)
      ->insert($objeto);

      if($inseriu){
        return true;
      }
      else{
        return false;
      }
    }
  }

  // Transforma a consulta no banco de dados pelo usuário em um objeto, com as informações necessárias para criar uma conta Moip
  public static function objetoConta($id){
    $data = DB::table('users')
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

      if(count($data) > 0){
        return (array)$data[0];
      }
      else{
        return null;
      }
  }
  
}
