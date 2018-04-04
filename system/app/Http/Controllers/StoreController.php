<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Input;
use Validator;
use Request;

use App\Product;
use App\Resposta;
use App\Store;
use App\Validation;

use DB;

class StoreController extends Controller
{
	// Campos que eu quero receber do banco de dados
	protected $campos = ['id', 'name', 'description'];

	// Criar Loja - OK
	public function newStore(){
		$this->isLogged();
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

		$inseriu = Store::add($data);

		if(!$inseriu){
			$this->return->setFailed("Ocorreu um erro ao criar sua loja.");
			return;
		}
	}

	// Alterar Loja - OK
	public function updateStore(){
		$this->isLogged();
		$data = $this->get_post();

    // Verifica se o usuário logado tem loja
    $existe = Store::storeExists($_SESSION['user_id']);

    if(!$existe){
      $this->return->setFailed("Nenhuma loja foi criada para este usuário.");
      return;
    }

    $alterou = Store::updateStore($data, $_SESSION['user_id']);

    // Verifica se alterou msm
    if(!$alterou){
      $this->return->setFailed("Ocorreu um erro na hora de alterar sua loja.");
			return;
    }else{
			return;
		}
	}

	// Alterar imagem da loja - OK
	public function uploadStoreLogo(){
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

		$imagem = DB::table(Store::TABLE_NAME)
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

			$alterar = DB::table(Store::TABLE_NAME)
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

	// Alterar banner da loja - OK
	public function uploadBannerImage(){
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
	public function toggleStatusStore(){
		$this->isLogged();
		$mudar = Store::toggleStatusStore($_SESSION['user_id']);

		if(!$mudar){
			$this->return->setFailed("Ocorreu um erro ao tentar alterar o status da sua loja.");
			return;
		}

	}

	// Pega uma loja baseada no seu unique_id
	public function getStore(){
		$data = $this->get_post();
		$loja = Store::getStore($data['unique_id']);

		if($loja == null){
			$this->return->setFailed("Nenhuma loja encontrada com esse identificador.");
		}else{
			$this->return->setObject($loja);
		}

	}

	// Lista todas as lojas criadas e ativas
	public function getAllStores(){
		// $lojas = Lojas::pegarTodasLojas();
		$lojas = Store::getStores();

		if($lojas == null){
			$this->return->setFailed("Nenhuma loja encontrada.");
			$this->return->setObject(array());
			return;
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

	public function numberOfSolds(){
		$this->isLogged();
		$numero = DB::table('stores')
		->join('products', 'products.store_id', '=', 'stores.id')
		->where('stores.id', '=', $_SESSION['user_id'])
		->sum('products.solds');

		$this->return->setObject($numero);
	}

	public function numberOfActive(){
		$this->isLogged();
		$numero = DB::table('stores')
		->join('products','products.store_id', 'stores.id')
		->where('stores.owner_id', $_SESSION['user_id'])
		->where('products.status', 'ativado')
		->count();

		$this->return->setObject($numero);
	}

	public function numberOfNonActive(){
		$this->isLogged();
		$numero = DB::table('stores')
		->join('products','products.store_id', 'stores.id')
		->where('stores.owner_id', $_SESSION['user_id'])
		->where('products.status', 'desativado')
		->count();

		$this->return->setObject($numero);
	}

	// Pega os produtos da loja
	public function getStoreProducts(){
		$data = $this->get_post();
		
		$products = Product::getProductsFromStore($data['unique_id']);

    if(count($products) > 0){
			$this->return->setObject($products);
		}
		else{			
      $this->return->setFailed("Esta loja não possui produtos ainda.");
      return;      
    }
	}

	public function getStoreID(){
		$data = $this->get_post();
	}

}
