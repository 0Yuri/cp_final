<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class Evaluation extends Model
{

  const TABLE_NAME = "evaluations";

  public static function evaluate($avaliador, $avaliado, $avaliacao, $order_id){

    $data = array(
      'rate' => $avaliacao,
      'evaluator_id'  => $avaliador,
      'evaluated_id' => $avaliado,
      'order_id' => $order_id
    );

    $inserir = DB::table(Evaluation::TABLE_NAME)
    ->insert($data);

    if($inserir){
      return true;
    }
    else{
      return false;
    }

  }
}
