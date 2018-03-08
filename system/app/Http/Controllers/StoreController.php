<?php

namespace App\Http\Controllers;

use Request;
use DB;
use App\Resposta;
use App\Store;
use App\Lojas;
use App\Validation;
use Illuminate\Support\Facades\Input;
use Validator;

class StoreController extends Controller
{
	// Campos que eu quero receber do banco de dados
	protected $campos = ['id', 'name', 'description'];

	// Criar Loja
	public function nova_loja(){
		$this->isLogged();
		// $data = $this->get_post();
		$data = $_POST;

		$data['owner_id'] = $_SESSION['user_id'];

		$nome_loja = str_ireplace(" ", "", $data['name']);

		$data['unique_id'] = uniqid('STORE-'.$nome_loja);

		// Validações
		$validar = new Validation();

		$status = $validar->validateAll($data);

		if(strlen($status) > 0){
			$this->return->setFailed($status);
			return;
		}

		if(Input::hasFile('image')){
      $image = Input::file('image');
			if(!Input::file('image')->isValid()){
	      $this->return->setFailed("Inválida.");
	      return;
	    }
    }
    else{
      $this->return->setFailed("Nenhuma imagem foi enviada.");
      return;
    }

		$diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
    $destino = $diretorio . "stores" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR;

    $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

		if(!$image->move($destino, $nomeHash)){
			$this->return->setFailed("Ocorreu um erro ao realizar o upload da imagem.");
			return;
		}

		$data['profile_image'] = 'users' . DIRECTORY_SEPARATOR . $nomeHash;

		$inseriu = Store::salvarLoja($data);

		if(!$inseriu){
			$this->return->setFailed("Ocorreu um erro ao criar sua loja.");
			return;
		}
	}

	// Alterar Loja
	public function alterar_loja(){
		$this->isLogged();
		$data = $this->get_post();

    // Verifica se existe a loja antes de tentar atualizar
    $existe = Store::existeLoja($_SESSION['user_id']);

    if(!$existe){
      $this->return->setFailed("Nenhuma loja foi criada para este usuário.");
      return;
    }

    $alterou = Store::alterarLoja($data, $_SESSION['user_id']);

    // Verifica se alterou msm
    if(!$alterou){
      $this->return->setFailed("Ocorreu um erro na hora de alterar sua loja.");
			return;
    }else{
			return;
		}
	}

	// alterar imagem da loja
	public function alterarImagem(){
		$this->isLogged();
		$data = $_POST;

		if(Input::hasFile('imagem')){
      $image = Input::file('imagem');
			if(!Input::file('imagem')->isValid()){
	      $this->return->setFailed("Foto Inválida.");
	      return;
	    }
    }
    else{
      $this->return->setFailed("Nenhuma imagem foi recebida.");
      return;
    }

		$imagem = DB::table('stores')
		->select('profile_image')
		->where('owner_id', $_SESSION['user_id'])
		->where('id', $data['loja'])
		->get();

		if(count($imagem) > 0){
			$imagem = $imagem[0]->profile_image;
		}
		else{
			$this->return->setFailed("Nenhuma loja foi encontrada.");
			return;
		}

    $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
    $destino = $diretorio . "stores" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR;
		$destino_excluido = $diretorio . "stores" . DIRECTORY_SEPARATOR . "logo" . DIRECTORY_SEPARATOR;

    $nomeHash =  md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();

    if(!$image->move($destino, $nomeHash)){
      $this->return->setFailed("Ocorreu um erro ao fazer o upload da sua foto.");
      return;
    }
    else{

			$nome_arquivo = 'users/' . $nomeHash;

			$alterar = DB::table('stores')
			->where('id', $data['loja'])
			->update(['profile_image' => $nome_arquivo]);

			if(!$alterar){
				$this->return->setFailed("Ocorreu um erro ao trocar a foto.");
				return;
			}
			else{
				for($i = 1; $i < 9; $i++){
					if($imagem == 'default_profile' . $i . '.png'){
						return;
					}
				}
				if(!unlink($destino_excluido . $imagem)){
					$this->return->setFailed("Nenhuma imagem foi removida.");
					return;
				}
			}
    }

	}

	public function alterarBanner(){
		$this->isLogged();

		$data = $_POST;

		if(Input::hasFile('imagem')){
      $image = Input::file('imagem');
			if(!Input::file('imagem')->isValid()){
	      $this->return->setFailed("Foto Inválida.");
	      return;
	    }
    }
    else{
      $this->return->setFailed("Nenhuma imagem foi recebida.");
      return;
    }

		$loja = DB::table('stores')
		->select('banner_image')
		->where('owner_id', $_SESSION['user_id'])
		->where('id', $data['loja'])
		->get();

		if(count($loja) > 0){
			$loja = $loja[0]->banner_image;
		}
		else{
			$this->return->setFailed("Nenhuma loja encontrada.");
			return;
		}

    $diretorio = realpath(storage_path() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR;
		$destino_excluido = $diretorio . "stores" . DIRECTORY_SEPARATOR . "banner" . DIRECTORY_SEPARATOR;
		$destino = $diretorio . "stores" . DIRECTORY_SEPARATOR . "banner" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR;

		$nomeHash = md5($image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();

		if(!$image->move($destino, $nomeHash)){
			$this->return->setFailed("Ocorreu um erro ao fazer o upload da sua foto.");
      return;
		}
		else{
			$nome_arquivo = "users/" . $nomeHash;

			$alterar = DB::table('stores')
			->where('id', $data['loja'])
			->update(['banner_image' => $nome_arquivo]);

			if(!$alterar){
				$this->return->setFailed("Ocorreu um erro ao trocar a foto.");
				return;
			}
			else{
				for($i = 1; $i < 9; $i++){
					if($loja == 'default_banner' . $i . '.png'){
						return;
					}
				}
				if(!unlink($destino_excluido . $loja)){
					$this->return->setFailed("Nenhuma imagem foi removida.");
					return;
				}
			}
		}

	}

	// Ativar/Desativar loja
	public function toggle_loja(){
		$this->isLogged();
		$mudar = Store::mudarStatusLoja($_SESSION['user_id']);

		if(!$mudar){
			$this->return->setFailed("Ocorreu um erro ao tentar alterar o status da sua loja.");
			return;
		}

	}

	// Pega uma loja baseada no seu id utilizando GET
	public function getStore(){
		$data = $this->get_post();
		// $loja = Store::pegarLoja($data['name']);
		$loja = Lojas::pegarLoja($data['unique_id']);

		if($loja == null){
			$this->return->setFailed("Nenhuma loja encontrada com esse identificador.");
		}else{
			$this->return->setObject($loja);
		}

	}

	// Lista todas as lojas criadas
	public function getAllStores(){
		$lojas = Lojas::pegarTodasLojas();

		if($lojas == null){
			$this->return->setFailed("Nenhuma loja encontrada.");
		}else{
			$this->return->setObject($lojas);
		}

	}

	// Pega o número de produtos vendidos pela loja
	public function numberOfSales(){
		$data = $this->get_post();

		$numero = DB::table('stores')
		->join('products', 'products.store_id', '=', 'stores.id')
		->where('stores.id', '=', $data['id'])
		->sum('products.solds');

		$this->return->setObject($numero);
	}

	public function lojaID(){
		$data = $this->get_post();
	}

}