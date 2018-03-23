<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Session extends Model
{
    
  // Verifica se existe uma sessão
  public static function checkSession(){
    return isset($_SESSION['user_id']);
  }

  // Realiza um login, se o login e senha estiverem certos
  public static function login($email, $password){
    $user = DB::table('users')
    ->select('id', 'email', 'password')
    ->where('email', $email)
    ->get();

    if(count($user) > 0){
      $user = $user[0];
      if(password_verify($password, $user->password)){
        return $user->id;
      }
      else{
        return null;
      }
    }else{
      return null;
    }
  }

}
