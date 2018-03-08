<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class SentMessages extends Model
{

  public static function get($user_id, $page=0){
    $mensagens = DB::table('messages')
    ->join('users', 'users.id', '=', 'messages.destiny_id')
    ->select('messages.*', 'users.name', 'users.last_name')
    ->where('messages.writer_id', $user_id)
    ->skip($page * 8)
    ->take(8)
    ->get();

    if(count($mensagens) > 0){
      return $mensagens;
    }
    else{
      return null;
    }
  }

  public static function getPages($user_id){
    $mensagens = DB::table('messages')
    ->join('users', 'users.id', '=', 'messages.destiny_id')
    ->where('messages.writer_id', $user_id)
    ->count();

    if($mensagens < 8){
      return 0;
    }
    else{
      $resto = $mensagens%8;

      $qtd = ($mensagens - $resto) % 8;

      if($resto > 0){
        $qtd++;
      }

      return $qtd;
    }
  }
}
