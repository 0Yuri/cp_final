<?php

namespace App\Http\Controllers;

use Moip\Moip;
use Moip\Auth\OAuth;

use App\Resposta;
use App\User;
use App\CPF;
use App\Order;
use App\Client;
use Moip\Exceptions;
use Moip\Helper\Filters;
use Moip\Helper\Links;
use Moip\Helper\Pagination;

use App\MoipAccount;
use App\MoipClient;
use App\MoipOrder;
use App\MoipPayment;

use App\Cart;
use App\Wallet;

use DB;
use DateTime;

class MoipController extends Controller
{
  protected $access_token = "a4face756e9e4e5c977b0b6449d4e168_v2";
  protected $moip;
  const ACCOUNT_ID = "MPA-B4ABF9C3ED72";

  public function __construct(){
    parent::__construct();
    $this->moip = new Moip(new OAuth($this->access_token), Moip::ENDPOINT_SANDBOX);
  }

  public function pagarBoleto(){
    $this->isLogged();
    $logged_id = $_SESSION['user_id'];

    // Cliente Section
    $cliente_id = MoipClient::getClientId($logged_id);
    if($cliente_id != null){
      $cliente = MoipClient::consultarCliente($this->moip, $cliente_id);
    }
    else{
      $this->return->setFailed("Nenhum cliente foi encontrado.");
      return;
    }
    // Fim da Cliente Section

    if(count($_SESSION['order']) > 1){
      $orders = MoipOrder::criarMultiPedidos($this->moip, $_SESSION['order'], $cliente, 'boleto');
      if($orders != null){
        $pagamento = MoipPayment::pagarBoletoMulti($orders);
        if($pagamento != null){
          $pagamento = json_decode(json_encode($pagamento), true);
          $this->return->setObject($pagamento['_links']['checkout']['payBoleto']['printHref']);
          return;
        }
        else{
          $this->return->setFailed("Ocorreu um erro ao gerar o seu boleto.");
          return;
        }
      }
      else{
        $this->return->setFailed("Ocorreu um erro ao gerar os seus pedidos.");
        return;
      }
    }
    else{
      $order = MoipOrder::criarPedidoSimples($this->moip, current($_SESSION['order']), $cliente, 'boleto');
      if($order != null){
        $pagamento = MoipPayment::pagarBoletoSimples($order);
        if($pagamento != null){
          $this->return->setObject($pagamento->getHrefBoleto());
          return;
        }
        else{
          $this->return->setFailed("Ocorreu um erro ao gerar o seu boleto.");
          return;
        }
      }
      else{
        $this->return->setFailed("Ocorreu um erro ao gerar o seu pedido.");
        return;
      }
    }

  }

  public function pagarCartao(){
    $this->isLogged();
    $data = $this->get_post();
    $logged_id = $_SESSION['user_id'];

    $usuario = User::createHolder($logged_id);
    if($usuario == null){
      $this->return->setFailed("Ocorreu um erro ao gerar informações essenciais para o pagamento do pedido.");
      return;
    }

    $holder = MoipPayment::gerarHolder($this->moip, $usuario);
    if($holder == null){
      $this->return->setFailed("Ocorreu um erro ao gerenciar seu pagamento.");
      return;
    }

    // Cliente Section
    $cliente_id = MoipClient::getClientId($logged_id);
    if($cliente_id != null){
      $cliente = MoipClient::consultarCliente($this->moip, $cliente_id);
    }
    else{
      $this->return->setFailed("Nenhum cliente foi encontrado.");
      return;
    }
    // Fim da Cliente Section

    if(count($_SESSION['order']) > 1){
      $orders = MoipOrder::criarMultiPedidos($this->moip, $_SESSION['order'], $cliente, 'cartao');
      if($orders != null){
        $pagamento = MoipPayment::pagarCartaoMulti($orders, $holder, $data['number'], $data['cvc'], $data['expYear'], $data['expMonth'], $data['parcelas']);
        if($pagamento != null){
          return;
        }
        else{
          $this->return->setFailed("Ocorreu um erro ao realizar o seu pagamento.");
          return;
        }
      }
      else{
        $this->return->setFailed("Ocorreu um erro ao gerar os seus pedidos.");
        return;
      }
    }
    else{
      $order = MoipOrder::criarPedidoSimples($this->moip, current($_SESSION['order']), $cliente, 'cartao');
      if($order != null){
        $pagamento = MoipPayment::pagarCartaoSimples($order, $holder, $data['number'], $data['cvc'], $data['expYear'], $data['expMonth'], $data['parcelas']);
        if($pagamento != null){
          return;
        }
        else{
          $this->return->setFailed("Ocorreu um erro ao realizar o seu pagamento.");
          return;
        }
      }
      else{
        $this->return->setFailed("Ocorreu um erro ao gerar o seu pedido.");
        return;
      }
    }
  }


  // Sacar dinheiro
  public function sacarDinheiro(){
    $data = $this->get_post();

    $token = $this->onlyToken($_SESSION['user_id']);
    if($token == null){
      $this->return->setFailed("Nenhum token foi gerado.");
      return;
    }
    $moipUser = new Moip(new OAuth($token), Moip::ENDPOINT_SANDBOX);


    $status = Wallet::withdraw($moipUser, $data['amount'], $data['bank_number'],
     $data['agency_number'], $data['agency_check_number'],
      $data['account_number'], $data['account_check_number'],
       $data['holder_name'], $data['tax_document']);

    if($status['success']){
      // Salvar a transferencia
      // Transfer::salvarTransferencia();
    }
    else{
      $this->return->setFailed($status);
    }
  }
  // Pegar Saldo
  public function pegarSaldo(){
    $this->isLogged();

    $Authorization = MoipAccount::getAuthorizationBearer($_SESSION['user_id']);

    $status = Wallet::balance($Authorization);

    if($status != null){
      $this->return->setObject($status);
      return;
    }
    else{
      $saldo = array(
          'disponivel' => 0.00,
          'indisponivel' => 0.00,
          'futuro' => 0.00
        );
        $this->return->setFailed("Nenhum codigo foi requisitado.");
        $this->return->setObject($saldo);
        return;
    }
    $this->return->setObject($saldo);
  }


}