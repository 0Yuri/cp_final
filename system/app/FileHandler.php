<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileHandler extends Model
{
  public static function verifyStoreImage($name){
    $target_file = realpath(dirname(BASE_PATH) . '/..') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'stores' . DIRECTORY_SEPARATOR . 'logo' . DIRECTORY_SEPARATOR . $name;
    if(file_exists($target_file)){
      return true;
    }
    else{
      return false;
    }
  }

  public static function verifyProductImage($name){
    $target_file = realpath(dirname(BASE_PATH) . '/..') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $name;
    if(file_exists($target_file)){
      return true;
    }
    else{
      return false;
    }
  }
}
