<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
  // Salvar um pedido de contato
  public static function salvar($data){
    $adicionou = DB::table('contact')
    ->insert($data);

    if($adicionou){
      return true;
    }else{
      return false;
    }
  }
}
