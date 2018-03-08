<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Avaliacoes extends Model
{
  public static function salvarAvaliacao($avaliador, $avaliado, $avaliacao, $order_id){
    $data = array(
      'rate' => $avaliacao,
      'evaluator_id'  => $avaliador,
      'evaluated_id' => $avaliado,
      'order_id' => $order_id
    );

    $inserir = DB::table('evaluations')
    ->insert($data);

    if($inserir){
      return true;
    }
    else{
      return false;
    }
  }
}
