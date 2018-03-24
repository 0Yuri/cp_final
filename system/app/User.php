<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Address;

class User extends Model
{
  const TABLE_NAME = 'users';

  // Salva um usuário novo no banco de dados
  public static function add($data){
    $usuario = (array)$data['user_info'];
    $endereco = (array)$data['address_info'];

    if(!isset($data)){
      return false;
    }
    else{
      // Insere o usuario e retorna o id para referenciar no endereco
      $usuario['password'] = password_hash($usuario['password'], PASSWORD_DEFAULT);

      $inseriu = DB::table(User::TABLE_NAME)
      ->insertGetId($usuario);

      if($inseriu){
        // Atribui ao campo user_id o id do usuario adicionad
        $endereco['user_id'] = $inseriu;
        $endereco = Address::add($endereco);
        if($endereco){
          return $inseriu;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
  }

  // Altera um usuário
  public static function update($data){
    $alterou = DB::table(User::TABLE_NAME)
    ->where('email', $data['email'])
    ->update($data);

    if($alterou){
      return true;
    }else{
      return false;
    }
  }

  // Verifica se já existe um usuário com o email cadastrado
  public static function doesEmailExists($email){
    //verifica se já existe.
    $usuario = DB::table(User::TABLE_NAME)
    ->select('email')
    ->where('email', '=', $email)
    ->get();

    if(count($usuario) > 0){
      return true;
    }else{
      return false;
    }
  }

  // Valida a senha com confirmar senha
  public static function validate_password($senha,$confirma){
    if($senha != $confirma){
      return false;
    }
    else{
      return true;
    }
  }

  // Pega o usuário logado pelo seu id
  public static function getLoggedUser($id){
    $fillable = [ 'name', 'last_name', 'birthdate', 'email', 'rg', 'cpf', 'ddd_1', 'tel_1', 'ddd_2', 'tel_2'];

    $usuario = DB::table(User::TABLE_NAME)
    ->select($fillable)
    ->where('id', $id)
    ->get();

    if(count($usuario) > 0){
      $usuario = (array)$usuario[0];
      // Desconverter a data
      $data = explode("-", $usuario['birthdate']);
      $d = mktime(0,0,0, $data[1], $data[2], $data[0]);
      $usuario['birthdate'] = date("d-m-Y", $d);
      return $usuario;
    }else{
      return null;
    }
  }

  // Pega o usuário pelo seu id
  public static function grabUserById($id){
    $fillable = [
      'name', 'last_name', 'gender', 'created_at'
    ];

    $usuario = DB::table(User::TABLE_NAME)
    ->select('*')
    ->where('name_id', '=', $id)
    ->get();

    if(count($usuario) > 0){
      return (array)$usuario[0];
    }else{
      return null;
    }

  }

  public static function grabMoipAccountId($user_id){
    $account_id = DB::table('moip_accounts')
    ->select('account_id')
    ->where('user_id', $user_id)
    ->get();

    if(count($account_id) > 0){
      return $account_id[0]->account_id;
    }
    else{
      return null;
    }
  }

  public static function isNameIdInUse($name_id){
    $existe = DB::table(User::TABLE_NAME)
    ->where('name_id', $name_id)
    ->get();

    if(count($existe) > 0){
      return true;
    }
    else{
      return false;
    }
  }

  public static function createHolder($user_id){
    $usuario = DB::table(User::TABLE_NAME)
    ->join('address', 'address.user_id', '=', 'users.id')
    ->select('users.name', 'users.last_name', 'users.birthdate as aniversario', 'users.cpf', 'users.ddd_1 as ddd', 'users.tel_1 as telefone',
    'address.*')
    ->where('users.id', $user_id)
    ->get();

    if(count($usuario) > 0){
      return (Array)$usuario[0];
    }
    else{
      return null;
    }
  }

}
