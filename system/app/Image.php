<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Image extends Model
{
  public static function salvarImagemProduto($nome, $product_id, $type="extra"){
    $imagem_info = array(
      'type' => $type,
      'product_id' => $product_id,
      'filename' => 'users/' . $nome
    );

    $inserir = DB::table('product_images')
    ->insert($imagem_info);

    if($inserir){
      return true;
    }
    else{
      return false;
    }
  }
}
