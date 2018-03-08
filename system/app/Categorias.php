<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Categorias extends Model
{
  // Pega todas as categorias
  public static function pegarCategorias(){
    $fillable = ['name', 'id'];
    $categorias = DB::table('categories')
    ->select($fillable)
    ->get();

    if(count($categorias) > 0){
      return $categorias;
    }else{
      return null;
    }
  }

  // Salva uma nova categoria
  public static function salvarCategoria($data){
    $adicionou = DB::table(TABLE_NAME)
    ->insert($data);

    if($adicionou){
      return true;
    }else{
      return false;
    }
  }
}
