<?php

namespace App\Http\Controllers;

use Request;
use App\Resposta;
use DB;
use App\User;
use App\Store;
use App\Product;
use App\Produtos;
use App\Session;
use App\FileHandler;
use App\Order;
use App\UsuarioBanido as Ban;

class SessionController extends Controller
{

  // Realiza o login e seta o id na sessão
  public function login(){
    $data = $this->get_post();
    $session = Session::login($data['email'], $data['password']);

    if(Ban::verificar($session)){
      $this->return->setFailed("Você está bloqueado de acessar o nosso sistema.");
      return;
    }
    else{
      if($session != null){
        $_SESSION['user_id'] = $session;
      }else{
        $this->return->setFailed("Login incorreto, tente novamente.");
      }
    }

  }

  // Realiza o logout acabando com a sessão(usuario e carrinho)
  public function logout(){
    if(isset($_SESSION['user_id'])){
      session_unset();
    }else{
      $this->return->setFailed("Sessão expirada ou inexistente.");
    }
  }

  // Retorna TRUE para sessão ativa, e FALSE para sessão inexistente
  public function checkSession(){
    if(!Session::checkSession()){
      $this->return->setFailed("Sessão expirada ou inexistente.");
    }
  }

  // Pega informações do usuário logado
  public function get_infos(){
    if(isset($_SESSION['user_id'])){
      $usuario = User::getLoggedUser($_SESSION['user_id']);
      if($usuario == null){
        $this->return->setFailed("Ocorreu um erro ao receber dados do usuario.");
        return;
      }else{
        $this->return->setObject($usuario);
        return;
      }
    }else{
      $this->return->setFailed("Sessão expirada ou inexistente.");
    }
  }

  // Checa o status se a loja foi criada
  public function checkStore(){
    $this->isLogged();
    $loja = Store::pegarLojaLogado($_SESSION['user_id']);

    if($loja == null){
			$this->return->setFailed("O usuário não possui loja cadastrada.");
			return;
		}
  }

  // Pega a loja do usuario logado
	public function logged_store(){
		$this->isLogged();

		$loja = Store::pegarLojaLogado($_SESSION['user_id']);

		if($loja == null){
			$this->return->setFailed("O usuário não possui loja cadastrada.");
			return;
		}else{
      $status = FileHandler::verifyStoreImage($loja->profile_image);
      if(!$status){
        $loja->profile_image = "default_profile1.png";
      }
      $this->return->setObject($loja);
    }
	}

  // Pega os produtos da loja do usuário logado
  public function logged_products(){
    $this->isLogged();
    $data = $this->get_post();

    if(!isset($data['page']) || strlen($data['page']) <= 0){
      $data['page'] = 0;
    }

    // $produtos = Product::pegarProdutosLogado($_SESSION['user_id'], $data['page']);
    $produtos = Produtos::pegarProdutosLogado($_SESSION['user_id'], $data['page']);

    if($produtos == null){
      $this->return->setFailed("Esta loja não possui nenhum produto.");
    }else{
      $this->return->setObject($produtos);
    }
  }

  // Status da loja
  public function status_store(){
    $this->isLogged();
    $status = Store::statusLoja($_SESSION['user_id']);

    if($status){
      return;
    }
    else{
      $this->return->setFailed("Loja não criada ou desativada.");
      return;
    }
	}

}
