<?php

namespace App\Http\Controllers;

use App\Favoritos;
use App\Product;
use DB;

class FavoritesController extends Controller
{
    // Adicionar Novo Favorito a lista do usuário
    public function adicionar_favorito(){
      $this->isLogged();
      $data = $this->get_post();

      $id_produto = DB::table('products')
      ->select('id')
      ->where('unique_id', $data['unique_id'])
      ->get();

      if(count($id_produto) > 0){
        $id_produto = $id_produto[0]->id;
      }

      $existe = Favoritos::existeFavorito($_SESSION['user_id'],$id_produto);

      if($existe){
        $this->return->setFailed("Já foi adicionado aos favoritos.");
        exit();
      }

      $favorito = array(
        'user_id' => $_SESSION['user_id'],
        'product_id' => $id_produto
      );

      $adicionou = Favoritos::salvarFavorito($favorito);

      if(!$adicionou){
        $this->return->setFailed("Ocorreu um erro ao adicionar aos favoritos.");
        return;
      }

    }

    // Remover dos favoritos
    public function remover_favorito(){
      $data = $this->get_post();

      $remover = Favoritos::removerFavorito($data['id']);

      if($remover){
        return;
      }else{
        $this->return->setFailed("Ocorreu um erro ao tentar remover dos favoritos.");
        return;
      }

    }

    // Pegar lista de favoritos do usuário
    public function pegar_favoritos(){
      $this->isLogged();
      $data = $this->get_post();
      $page = 0;

      if(isset($data['page']) && strlen($data['page']) > 0){
        $page = $data['page'];
      }

      $favoritos = Favoritos::pegarFavoritos($_SESSION['user_id'], $page);

      if($favoritos == null){
        $this->return->setFailed("Nenhum favorito foi encontrado.");
        exit();
      }else{
        $this->return->setObject($favoritos);
      }

    }
}
