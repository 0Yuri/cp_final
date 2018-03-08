<?php

namespace App\Http\Controllers;

use DB;
use App\Image;
use App\Store;
use App\Product;
use App\Produtos;

use Illuminate\Support\Facades\Input;
use Validator;

class ProductController extends Controller
{
  // Criar produto - OK
  public function novoProduto(){
    $this->isLogged();

    if(!$this->checkStore()){
      $this->return->setFailed("Nenhuma loja criada pelo usuário.");
      return;
    }

    $data = $_POST;

    if($data['shipping'] == true){
      $data['shipping'] = 1;
    }

    if($data['local'] == true){
      $data['local'] = 1;
    }

    $data['price'] = $this->converterPreco($data['price']);

    $data['original_price'] = $this->converterPreco($data['original_price']);

    $loja_id = Store::getStoreID($_SESSION['user_id']);

    $data['store_id'] = $loja_id;
    
    $nome_produto = str_ireplace(" ", "", $data['name']);

    $data['unique_id'] = uniqid('PROD-'.$nome_produto);

    $inseriu = Product::salvarProduto($data);

    if(!$inseriu){
      $this->return->setFailed("Erro ao criar o produto.");
      return;
    }
    else{
      if(Input::hasFile('imagem')){
        $image = Input::file('imagem');
        if(!Input::file('imagem')->isValid()){
          $this->return->setFailed("Imagem Inválida.");
          return;
        }
      }
      else{
        $this->return->setFailed("Nenhuma imagem foi recebida.");
        return;
      }

      $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
      $destino = $diretorio . "site" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR;

      $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

      if(!$image->move($destino, $nomeHash)){
        $this->return->setFailed("Ocorreu um erro ao fazer o upload da sua foto.");
        return;
      }
      else{

        $inserir = Image::salvarImagemProduto($nomeHash, $inseriu, 'profile');

        if(!$inserir){
          $this->return->setFailed("Ocorreu um erro ao armazenar sua imagem.");
          return;
        }
      }

    }
  }

  // Alterar produto
  public function alterar_produto(){
    $data = $this->get_post();

    if(isset($data['profile_image'])){
      unset($data['profile_image']);
    }
    if(isset($data['imagens'])){
      unset($data['imagens']);
    }

    $alterar = Product::alterarProduto($data);

    if(!$alterar){
      $this->return->setFailed("Ocorreu um erro ao alterar o produto.");
    }

  }

  // Upload imagem de perfil
  public function uploadProfile(){
    $data = $_POST;

    if(Input::hasFile('imagem')){
      $image = Input::file('imagem');
      if(!Input::file('imagem')->isValid()){
        $this->return->setFailed("Imagem inválida.");
        return;
      }
      else{
        $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
        $destino = $diretorio . "site" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR;
        $destino_excluido = $diretorio . "site" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR;

        $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

        if(!$image->move($destino, $nomeHash)){
          $this->return->setFailed("Ocorreu um erro ao fazer o upload da sua foto.");
          return;
        }
        else{

          $imagem_antiga = DB::table('product_images')
          ->where('product_id', $data['produto'])
          ->where('type', '=', 'profile')
          ->get();

          if(count($imagem_antiga) > 0){
            $imagem_antiga = $imagem_antiga[0];
          }

          $nomeFinal = 'users/' . $nomeHash;
          if(!Produtos::salvarImagem($data['produto'], $nomeFinal, 'profile')){
            $this->return->setFailed("Ocorreu um erro ao salvar esta imagem.");
            return;
          }
          else{
            if(!unlink($destino_excluido . $imagem_antiga->filename)){
              $this->return->setFailed("Ocorreu um erro ao excluir a foto anterior.");
              return;
            }
            else{
              $excluir = DB::table('product_images')
              ->where('id', $imagem_antiga->id)
              ->delete();
            }
          }
        }
      }
    }
    else{
      $this->return->setFailed("Nenhuma imagem foi encontrada.");
      return;
    }

  }

  // Upload de imagens extras
  public function uploadSimple(){
    $data = $_POST;

    $imagens = DB::table('product_images')
    ->where('product_id', $data['produto'])
    ->where('type', '=', 'extra')
    ->count();

    if($imagens >= 5){
      $this->return->setFailed("Este produto já possui 6 fotos, 1 de perfil e 5 extras.");
      return;
    }
    else{
      if(Input::hasFile('imagem')){
        $image = Input::file('imagem');

        if(!Input::file('imagem')->isValid()){
          $this->return->setFailed("Imagem inválida.");
          return;
        }
        else{
          $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
          $destino = $diretorio . "site" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR;
          $destino_excluido = $diretorio . "site" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR;

          $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

          if(!$image->move($destino, $nomeHash)){
            $this->return->setFailed("Ocorreu um erro ao fazer o upload da sua foto.");
            return;
          }
          else{

            $nomeFinal = 'users/' . $nomeHash;
            if(!Produtos::salvarImagem($data['produto'], $nomeFinal)){
              $this->return->setFailed("Ocorreu um erro ao salvar esta imagem.");
              return;
            }
          }
        }
      }
      else{
        $this->return->setFailed("Nenhuma imagem foi encontrada.");
        return;
      }
    }


  }

  public function deletePhoto(){
    $this->isLogged();
    $data = $this->get_post();
    $image_id = $data['id'];
    $product_id = $data['product_id'];
    $filename = $data['filename'];

    $arquivo = DB::table('product_images')
    ->select('filename')
    ->where('id','=', $image_id)
    ->where('filename', '=', $filename)
    ->get();

    if(count($arquivo) > 0){
      $filename = $arquivo[0]->filename;
    }
    else{
      $this->return->setFailed("Nenhum arquivo encontrado.");
      return;
    }


    $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
    $destino = $diretorio . "site" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR;

    if(!unlink($destino . $filename)){
      $this->return->setFailed("Erro ao excluir a foto.");
      return;
    }
    else{
      $deletar = DB::table('product_images')
      ->where('id', $image_id)
      ->delete();

      if(!$deletar){
        $this->return->setFailed("Ocorreu um erro ao excluir esta foto.");
        return;
      }
    }
  }

  public function removerImagem(){
    $this->isLogged();
    $data = $this->get_post();

    $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
    $destino = $diretorio . "site" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR;
    $filename = $data['filename'];

    $imagem = DB::table('product_images')
    ->select('product_id')
    ->where('id', '=', $data['id'])
    ->get();

    if(count($imagem) > 0){
      $produto_id = $imagem[0]->product_id;

      $store = DB::table('stores')
      ->join('products', 'products.store_id', '=', 'stores.id')
      ->where('stores.owner_id', $_SESSION['user_id'])
      ->where('products.id', $produto_id)
      ->get();

      if(count($store) > 0){
        $store = $store[0];
        if(!unlink($destino . $filename)){
          $this->return->setFailed("Nenhuma imagem foi removida.");
          return;
        }
        else{
          $deletar = DB::table('product_images')
          ->where('id', '=', $data['id'])
          ->where('product_id', '=', $store->id)
          ->delete();

          if(!$deletar){
            $this->return->setFailed("Nenhuma imagem foi removida.");
            return;
          }
        }
      }
    }
    else{
      $this->return->setFailed("Nenhuma imagem foi encontrada.");
      return;
    }
  }

  // Ativar produto
  public function ativar_produto(){
    $data = $this->get_post();

    $ativar = Product::ativarProduto($data);

    if(!$ativar){
      $this->return->setFailed("Ocorreu um erro ao reativar o produto.");
    }
  }
  // Desativar produto
  public function desativar_produto(){
    $data = $this->get_post();

    $deletou = Product::desativarProduto($data);

    if(!$deletou){
      $this->return->setFailed("Erro ao deletar o produto.");
      return;
    }
  }

  // Pegar Produto X
  public function getProduct(){
    $data = $this->get_post();

    $produto = Produtos::pegarProduto($data['unique_id']);

    if($produto != null){
      $this->return->setObject($produto);
    }
    else{
      $this->return->setFailed("Não existe nenhum produto com esse identificador.");
      return;
    }
  }

  // Pegar produto logado
  public function pegarProdutoLogado(){
    $this->isLogged();
    $data = $this->get_post();

    $produto = Produtos::pegarProdutoLogado($data['unique_id'], $_SESSION['user_id']);

    if($produto == null){
      $this->return->setFailed("Nenhum um produto com este nome pertence à sua loja.");
      return;
    }else{
      $this->return->setObject($produto);
      return;
    }
  }

  public function listarProdutos(){
    $data = $this->get_post();
    $condicoes = array();

    $condicoes[] = ['products.status', '=', 'ativado'];

    if(strlen($data['category']) > 0){
      if($data['category'] != 0){
        $condicoes[] = ['category_id', '=', $data['category']];
      }
    }

    if(strlen($data['page']) > 0){
      $page = $data['page'];
    }
    else{
      $page = 1;
    }

    if(isset($data['filter']) && strlen($data['filter']) > 0){
      $gender = $data['filter'];
    }
    else{
      $gender = null;
    }

    if(isset($data['quality']) && $data['quality'] != 'wherever'){
      $condicoes[] = ['quality', '=', $data['quality']];
    }

    $produtos = Product::pegarProdutos($condicoes, $gender, $page);

    if($produtos == null){
      $this->return->setFailed("Nenhum produto foi encontrado nesta categoria.");
      return;
    }else{
      $this->return->setObject($produtos);
    }
  }

  public function countActive(){
    $data = $this->get_post();
    $condicoes = array();
    $condicoes[] = ['status', '=', 'ativado'];

    if(strlen($data['category']) > 0){
      $condicoes[] = ['category_id', '=', $data['category']];
    }

    if(isset($data['filter']) && strlen($data['filter']) > 0){
      $condicoes[]  = ['gender', '=', $data['filter']];
    }

    $quantidade = Product::numeroProdutosAtivos($condicoes);

    $this->return->setObject($quantidade);
  }

  // Verifica se o usuário tem loja criada
  public function checkStore(){
    $loja = DB::table('stores')
    ->select('id')
    ->where('owner_id', '=', $_SESSION['user_id'])
    ->get();

    if(count($loja) > 0){
      return true;
    }else{
      return false;
    }
  }

  // Pega os produtos de determinada loja
  public function getProductFromStore(){
    $data = $this->get_post();

    $produtos = DB::table('stores')
    ->join('products', 'products.store_id', '=', 'stores.id')
    ->join('product_images', 'product_images.product_id', '=', 'products.id')
    ->select('products.unique_id', 'products.name', 'products.quality', 'products.price', 'products.gender', 'product_images.filename as imagem')
    ->where('stores.unique_id', '=', $data['unique_id'])
    ->where('product_images.type', 'profile')
    ->get();

    if(count($produtos) <= 0){
      $this->return->setFailed("Não existe nenhum produto nesta loja.");
    }else{
      $this->return->setObject($produtos);
    }
  }

  // Converte String para preço
  private function converterPreco($price){
    $price = explode(',', $price);
    $inteiro = (double) 0;
    $decimal = (double) 0;

    if(isset($price[0])){
      $inteiro = (double) $price[0];
    }
    if(isset($price[1])){
      $decimal = (double) $price[1];
      $decimal /= 100;
    }

    $valor = $inteiro + $decimal;
    return $valor;
  }

}
