<?php

namespace App\Http\Controllers;

use Moip\Moip;
use Moip\Auth\Connect;
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
use Illuminate\Http\Request;

class MoipController extends Controller
{
  protected $notification;
  protected $moip;
  protected $connect;
  const ACCOUNT_ID = MoipConstants::OWNER_ACCOUNT;

  public function __construct(){
    parent::__construct();
    $this->moip = new Moip(new OAuth(MoipConstants::ACCESS_TOKEN), Moip::ENDPOINT_SANDBOX);    
  }

  public function autorizarAppMoip(){
    // Limpa cache da sessão
    if(isset($_SESSION['moipAccountRef'])){
      unset($_SESSION['moipAccountRef']);
    }

    $connect = new Connect(MoipConstants::REDIRECT_URL, MoipConstants::APP_ID, true, Connect::ENDPOINT_SANDBOX);
    $connect->setClientSecret(MoipConstants::SECRET_SERIAL);
    // Set the code responsed by permissions
    $code = $_GET['code'];
    // Verificações básicas
    if($code != null){
      try{
        $connect->setCode($code);
        $auth = $connect->authorize();
        $token = $auth->accessToken;
        $moipAccount = $auth->moipAccount;

        if(is_null($token) || is_null($moipAccount)){
          $this->return->setFailed("Dados inválidos.");
        }
      }
      catch(\Moip\Exceptions\ValidationException $e){
        $this->return->setFailed("Ocorreu um erro de validação na sua operação.");
      }
    }
    else{
      $this->return->setFailed("Ocorreu um erro ao receber o código de autorização.");
    }
  }

  public function link(){
    $connect = new Connect(MoipConstants::REDIRECT_URL, MoipConstants::APP_ID, true, Connect::ENDPOINT_SANDBOX);
    $connect->setScope(Connect::RECEIVE_FUNDS)
    ->setScope(Connect::REFUND)
    ->setScope(Connect::MANAGE_ACCOUNT_INFO)
    ->setScope(Connect::RETRIEVE_FINANCIAL_INFO);    
    $this->return->setObject($connect->getAuthUrl());
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

    $dia = substr($data['birthdate'], 0, 2);
    $mes = substr($data['birthdate'], 3, 2);
    $ano = substr($data['birthdate'], 6, 4);

    if(!checkdate($mes, $dia, $ano)){
      $this->return->setFailed("Data inválida.");
      return;
    }
    
    // Inverte a data pro formato do moip
    $data['birthdate'] = $ano . "-" . $mes . "-" . $dia;

    $dataHolder = array(
      'fullname' => $data['name'],
      'birthdate' => $data['birthdate'],
      'ddd' => $data['ddd'],
      'phone' => $data['phone'],
      'cpf' => $data['cpf'],
      'street' => $data['street'],
      'complement' => $data['complement'],
      'number' => $data['address_number'],
      'neighborhood' => $data['neighborhood'],
      'city' => $data['city'],
      'UF' => $data['UF'],
      'cep' => $data['cep'],
    );

    $holder = MoipPayment::gerarHolder($this->moip, $dataHolder);

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
          $this->return->setObject($pagamento);
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
    // $json = file_get_contents('php://input');

    // $data = array(
    //   'info' => $json
    // );

    // print_r($json);
    
    // $inserir = DB::table("webhooks")->insert($data);
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
