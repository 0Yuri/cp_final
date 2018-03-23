<?php

namespace App\Http\Controllers;
use DB;
use App\Store;
use App\Product;
use Illuminate\Support\Facades\Input;
use Validator;

class UploadController extends Controller
{

  protected $basic_image = "default.png";

  function criarLoja(){
    if(Input::hasFile('file')){
      $image = Input::file('file');
    }
    else{
      $this->return->setFailed("Not image was received.");
      return;
    }

    if(!Input::file('file')->isValid()){
      $this->return->setFailed("Inválida.");
      return;
    }

    $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
    $destino = $diretorio . "stores" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR;

    $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

    if(!$image->move($destino, $nomeHash)){
      $this->return->setFailed("Ocorreu um erro ao fazer o upload da sua foto.");
      return;
    }
    else{
      $this->return->setObject($nomeHash);
    }
  }
  
  // Upload imagem de perfil - OK
  public function uploadProductProfile(){
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

        // $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $nomeHash = $this->generateImageName($image->getClientOriginalName(), $image->getClientOriginalExtension());

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
          if(!Product::saveImage($data['produto'], $nomeFinal, 'profile')){
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

  // Upload de imagens extras - OK
  public function uploadProductExtra(){
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

          // $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

          $filename = $image->getClientOriginalName();
          $extension = $image->getClientOriginalExtension();
          $filename = trim($filename, $extension);

          $nomeHash = $this->generateImageName($filename, $extension);

          if(!$image->move($destino, $nomeHash)){
            $this->return->setFailed("Ocorreu um erro ao fazer o upload da sua foto.");
            return;
          }
          else{

            $nomeFinal = 'users/' . $nomeHash;
            if(!Product::saveImage($data['produto'], $nomeFinal)){
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

  // Remover Imagens Extra de produto
  public function deleteProductExtra(){
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

  private function generateImageName($name, $extension){
    return uniqid(md5($name)) . ".". $extension;
  }
}
