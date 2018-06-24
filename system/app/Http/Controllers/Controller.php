<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Resposta;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $return;
    protected $post;

    public function __construct(){
    	$this->return = new Resposta();
      $this->post = json_decode(file_get_contents("php://input"));
    }

    public function __destruct(){
    	echo json_encode($this->return->get());
    }

    // Sessão check
    public function checkSession(){
      return isset($_SESSION['user_id']);
    }

    public function isLogged(){
      if(isset($_SESSION['user_id'])){
        return true;
      }else{
        $this->return->setFailed("Sessão expirada ou inexistente, realize o login para continuar.");
        exit();
      }
    }

    public function get_post(){
      return (array)$this->post;
    }

}
