<?php

namespace App\Http\Controllers;
use DB;
use App\Store;
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
  

  function testes(){
    print_r($_POST);
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

    $address = realpath(storage_path() . DIRECTORY_SEPARATOR .'..' . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;
    $destinationPath = $address . 'stores' . DIRECTORY_SEPARATOR . 'logo' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;

    if(!$image->move($destinationPath, $image->getClientOriginalName())){
      $this->return->setFailed("Ocorreu um erro ao salvar sua nova foto.");
      return;
    };

  }

  function uploadProducts(){
    $this->isLogged();
    if(!empty($_FILES)){
      $tempPath = $_FILES['file']['tmp_name'];
      $destinyPath = realpath(dirname(BASE_PATH) . '/..') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $_FILES['file']['name'];
      $status = move_uploaded_file($tempPath, $destinyPath);

      if($status){
        $image = array(
          'type' => 'profile',
          'product_id' => 7,
          'filename' => $_FILES['file']['name']
        );

        $salvar = DB::table('product_image')
        ->insert($image);

        if($salvar){
          return;
        }
        else{
          $this->return->setFailed("Ocorreu um erro ao fazer o upload do seu produto.");
        }
      }
    }
  }

  function uploadStore(){
    if(!empty($_FILES)){
      // Verifica se um erro está presente.
      if($_FILES['file']['error'] == 1){
        $this->return->setFailed("Ocorreu um erro ao receber a imagem.");
        exit();
      }
      // Tipo da imagem
      $imageFileType = $_FILES['file']['type'];
      // Verifica a Extensao e atribui para salvar posteriormente
      switch($imageFileType){
        case 'image/jpeg':
          $extensao = ".jpeg";
          break;
        case 'image/png':
          $extensao = ".png";
          break;
        case 'image/jpg':
          $extensao = ".jpg";
          break;
        default:
          $this->return->setFailed("Extensão do arquivo é inválida.");
          exit();
      }
      // Tamanho da imagem e análisa do mesmo
      $imageSize = $_FILES['file']['size'];
      if(($imageSize/1000) > 1024){
        $this->return->setFailed("O arquivo é muito grande, favor tente com um menor.");
        exit();
      }
      // Diretório temporário onde se encontra
      $tempPath = $_FILES['file']['tmp_name'];
      // Hash no nome + extensao
      $nomeHash = md5($_FILES['file']['name']) . $extensao;
      // Destino de armazenamento com o nome novo do arquivo
      $destino = realpath(dirname(BASE_PATH) . '/..') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR  . 'stores' . DIRECTORY_SEPARATOR . 'logo' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $nomeHash;
      // Salva a imagem
      $status = move_uploaded_file($tempPath, $destino);
      // Salvar na loja
      $nomeArquivo = "users".DIRECTORY_SEPARATOR.$nomeHash;
      // Verifica se deu certo
      if($status){
        $_SESSION['new_pic'] = $nomeHash;
        Store::mudarProfile($_SESSION['user_id'], $nomeArquivo);
        $this->return->setObject($nomeHash);
      }
      else{
        $this->return->setFailed("Não foi possível upar esta imagem.");
        exit();
      }
    }
    else{
      $this->return->setFailed("Nenhum arquivo foi recebido.");
      exit();
    }
  }
}
