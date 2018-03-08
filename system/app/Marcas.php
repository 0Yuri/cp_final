<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Marcas extends Model
{
  // Pega as marcas
  public static function pegarMarcas(){
    $marcas = DB::table('brands')
    ->select('name', 'id')
    ->get();

    if(count($marcas) > 0){
      return $marcas;
    }else{
      return null;
    }
  }

  // TODO: criar ToggleStatus para usar apenas uma função para mesma coisa

  // Desativa uma marca para não ser mais usada
  public static function desativarMarca($id){
    $desativar = DB::table('brands')
    ->where('id', $id)
    ->update(['status' => 'desativado']);

    if($desativar){
      return true;
    }
    else{
      return false;
    }
  }

  // Ativa uma marca
  public static function ativarMarca($id){
    $ativar = DB::table('brands')
    ->where('id', $id)
    ->update(['status' => 'ativado']);

    if($ativar){
      return true;
    }
    else{
      return false;
    }
  }

  // Salva uma nova marca
  public static function salvarMarca($data){

    $adicionou = DB::table('brands')
    ->insert($data);

    if($adicionou){
      return true;
    }else{
      return false;
    }
  }

}
