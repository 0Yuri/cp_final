<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UsuarioBanido extends Model
{
  
  public static function verificar($id){
    $usuario = DB::table('banned_users')
    ->where('banned_id', $id)
    ->count();

    if($usuario > 0){
      return true;
    }
    else{
      return false;
    }
  }

  public static function consultar($cpf){
    $consultar = DB::table('banned_users')
    ->select('users.*', 'banned_users.reason', 'banned_users.ban_date')
    ->join('users', 'users.cpf', '=', 'banned_users.cpf')
    ->where('banned_users.cpf', 'like', $cpf)
    ->get();

    if(count($consultar) > 0){
      return $consultar[0];
    }
    else{
      return null;
    }
  }

  public static function banir($id, $cpf, $rg, $email, $motivo){
    $banimento = array(
      'banned_id' => $id,
      'cpf' => $cpf,
      'rg' => $rg,
      'email' => $email,
      'reason' => $motivo
    );

    $inserir = DB::table('banned_users')
    ->insert($banimento);

    if($inserir){
      return true;
    }
    else{
      return false;
    }
  }

  public static function desbanir($id){
    $desbanir = DB::table('banned_users')
    ->where('banned_id', $id)
    ->delete();

    if($desbanir){
      return true;
    }
    else{
      return false;
    }
  }
}
