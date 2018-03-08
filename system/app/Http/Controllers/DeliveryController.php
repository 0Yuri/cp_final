<?php

namespace App\Http\Controllers;

use App\Validation;
use App\Address;

class DeliveryController extends Controller
{
  public function setEntregas(){
    $this->isLogged();
    $data = $this->get_post();
    $message = "";

    $data = json_decode(json_encode($data), true);

    foreach($data as $key => $valor){
      if(isset($_SESSION['order'][$key])){
        $_SESSION['order'][$key]['entrega'] = $valor['entrega'];
      }
    }


    foreach($_SESSION['order'] as $key => $order){
      if($order['entrega']['type'] == 'user'){
        $_SESSION['order'][$key]['entrega']['info'] = Address::pegarEndereco($_SESSION['user_id']);
      }

      switch($order['entrega']['type']){
        case 'user':
          $_SESSION['order'][$key]['entrega']['info'] = Address::pegarEndereco($_SESSION['user_id']);
          break;
        case 'other':
          // TODO: Validar os campos
          break;
        case 'retirada':
          // TODO: Validar se a loja permite
          break;
        default:
          $this->return->setFailed("Tipo de envio inválido.");
          return;
      }
    }


  }

  public function userAddress(){
    $this->isLogged();

    $user_id = $_SESSION['user_id'];

    $endereco = Address::pegarEndereco($user_id);

    if($endereco != null){
      $this->return->setObject($endereco);
    }
    else{
      $this->return->setFailed("Nenhum endereço encontrado.");
      return;
    }

  }

  public function calcularEntrega(){
    $data = $this->get_post();

    $data = $data['info'];

    $cep_loja = Address::getCEP($data->loja);
    $cep_origem = $data->entrega->info->cep;

    $fretes = $this->calcularFrete($cep_loja, $cep_origem);

    $this->return->setObject($fretes);
  }

  private function calcularFrete($cep_origem, $cep_destino, $peso = '1', $comprimento = '16', $altura = '5', $largura = '15', $valor="200"){

    // Logistica de como calcular o cep aqui
    $data['nCdEmpresa'] = '';
    $data['sDsSenha'] = '';
    $data['sCepOrigem'] = str_ireplace("-", "", $cep_origem);
    $data['sCepDestino'] = str_ireplace("-", "", $cep_destino);;
    $data['nVlPeso'] = $peso;
    $data['nCdFormato'] = '1';
    $data['nVlComprimento'] = $comprimento;
    $data['nVlAltura'] = $altura;
    $data['nVlLargura'] = $largura;
    $data['nVlDiametro'] = '0';
    $data['sCdMaoPropria'] = 's';
    $data['nVlValorDeclarado'] = $valor;
    $data['sCdAvisoRecebimento'] = 'n';
    $data['StrRetorno'] = 'xml';
    //$data['nCdServico'] = '40010';
    $data['nCdServico'] = '40010,41106';
    $data = http_build_query($data);
    $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
    $curl = curl_init($url . '?' . $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $result = simplexml_load_string($result);
    curl_close($curl);

    if ($result) {
      $entregas = array(
        'sedex' => null,
        'pac' => null
      );

      $resultado = json_decode(json_encode($result), true);

      $resultado = $resultado['cServico'];

      foreach($resultado as $forma){
        if($forma['Codigo'] == 40010){
          $entregas['sedex'] = array(
            'valor' => $forma['Valor'],
            'prazo' => $forma['PrazoEntrega']
          );
        }
        else{
          $entregas['pac'] = array(
            'valor' => $forma['Valor'],
            'prazo' => $forma['PrazoEntrega']
          );
        }
      }
      return $entregas;
    }
  }

  public function calculaPedido(){
    $data = $this->get_post();
    $this->return->setObject(array(
      'frete' => 0,
      'pac' => 0)
    );

  }
}
