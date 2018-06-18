<?php

namespace App\Http\Controllers;

use App\Shopping;
use App\Store;
use Moip\Moip;
use Moip\Auth\OAuth;
use App\MoipOrder;

class ShoppingController extends Controller
{  
  public function getAll(){
    $this->isLogged();
    $data = $this->get_post();
    $filtro = null;
    $pagina = 0;

    if(isset($data['filter'])){
      $filtro = $data['filter'];
    }

    if(isset($data['page'])){
      $pagina = $data['page'] - 1;
    }

    $compras = Shopping::getAll($_SESSION['user_id'], $filtro, $pagina);

    if($compras != null){
      $this->return->setObject($compras);
    }
    else{
      $this->return->setFailed("Nenhuma compra encontrada.");
      return;
    }
  }


}
