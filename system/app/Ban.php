<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    const TABLE_NAME = "banned_users";
  
  public static function verify($id){
    $usuario = DB::table(Ban::TABLE_NAME)
    ->where('banned_id', $id)
    ->count();

    if($usuario > 0){
      return true;
    }
    else{
      return false;
    }
  }

  public static function search($cpf){
    $consultar = DB::table(Ban::TABLE_NAME)
    ->select(User::TABLE_NAME . '.*', Ban::TABLE_NAME . '.reason', Ban::TABLE_NAME . '.ban_date')
    ->join(User::TABLE_NAME, Ban::TABLE_NAME . '.cpf', '=', Ban::TABLE_NAME . '.cpf')
    ->where(Ban::TABLE_NAME . '.cpf', 'like', $cpf)
    ->get();

    if(count($consultar) > 0){
      return $consultar[0];
    }
    else{
      return null;
    }
  }

  public static function ban($id, $cpf, $rg, $email, $motivo){
    $banimento = array(
      'banned_id' => $id,
      'cpf' => $cpf,
      'rg' => $rg,
      'email' => $email,
      'reason' => $motivo
    );

    $inserir = DB::table(Ban::TABLE_NAME)
    ->insert($banimento);

    if($inserir){
      return true;
    }
    else{
      return false;
    }
  }

  public static function unban($id){
    $desbanir = DB::table(Ban::TABLE_NAME)
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
