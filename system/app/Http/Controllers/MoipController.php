<?php

namespace App\Http\Controllers;

use Moip\Moip;
use Moip\Auth\OAuth;

use App\Resposta;
use App\User;
use App\CPF;
use App\Session;
use App\Order;
use App\Client;
use Moip\Exceptions;
/*
 * Já existe um objeto com nome Moip, por isso MoipConstants
 * para não gerar conflitos.
*/
use App\Moip as MoipConstants;
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
  // protected $access_token = "a4face756e9e4e5c977b0b6449d4e168_v2";
  protected $access_token = MoipConstants::ACCESS_TOKEN;
  protected $notification;
  protected $moip;
  const ACCOUNT_ID = MoipConstants::OWNER_ACCOUNT;

  public function __construct(){
    parent::__construct();
    $this->moip = new Moip(new OAuth($this->access_token), Moip::ENDPOINT_SANDBOX);

    $this->notification = $this->moip->notifications()->addEvent('ORDER.*')
    ->addEvent('PAYMENT.AUTHORIZED')
    ->setTarget('http://localhost/system/public/webhooks')
    ->create();
  }

  public function payWithBoleto(){
    $this->isLogged();
    $logged_id = $_SESSION['user_id'];

    if(isset($_SESSION['pagamento']) && isset($_SESSION['pagamento']['link'])){
      $this->return->setObject($_SESSION['pagamento']['link']);
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
      $orders = MoipOrder::criarMultiPedidos($this->moip, $_SESSION['order'], $cliente, 'boleto');
      if($orders != null){
        $pagamento = MoipPayment::pagarBoletoMulti($orders);
        if($pagamento != null){
          $pagamento = json_decode(json_encode($pagamento), true);
          $boleto = $pagamento['_links']['checkout']['payBoleto']['printHref'];
          $this->return->setObject($boleto);
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
          $boleto = $pagamento->getHrefBoleto();
          $this->return->setObject($boleto);
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

    if(isset($_SESSION['pagamento'])){
      $this->return->setObject($_SESSION['pagamento']['link']);
      Session::cleanAll();
      return;
    }
    else{
      $_SESSION['pagamento'] = array(
        'tipo' => "boleto",
        'link' => $boleto
      );
      Session::cleanAll();
    }
    
  }

  public function payWithCreditCard(){
    $this->isLogged();
    $data = $this->get_post();
    $logged_id = $_SESSION['user_id'];

    if(isset($data['parcelas']) && !$this->validarParcelas($data['parcelas'])){
      $this->return->setFailed("O número de parcelas é inválido para esta compra.");
      return;
    }

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
  public function withdrawMoney(){
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
  public function getAccountBalance(){
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

  // testando webhooks
  public function getWebHooks(){
    $json = file_get_contents('php://input');

    $data = array(
      'info' => $json
    );

    print_r($json);
    
    $inserir = DB::table("webhooks")->insert($data);
  }

  public function validarParcelas($parcela = 1){
    if(isset($_SESSION['order']) && !is_null($_SESSION['order'])){
      $parcelas = Cart::avaliarCarrinhoParcelas($_SESSION['order']);
      $tamanho = sizeof($parcelas);
      if($parcelas[($tamanho - 1)] < $parcela){
        return false;
      }
      else{
        return true;
      }
    }
    else{
      return false;
    }
  }

}
