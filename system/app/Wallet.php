<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Moip\Moip;

class Wallet extends Model
{
  const MOIP_LINK = "https://sandbox.moip.com.br/v2/balances";
  // Pega o saldo da conta moip
  public static function balance($Authorization){

    if(is_null($Authorization)){
      return null;
    }

    $url = Wallet::MOIP_LINK;
    // Inicia o processo de POST via JSON
    $ch = curl_init();
    // Desativa a verificação de SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Se o for true, retorna o objeto, se for false, imprime o resultado
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Header do post
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($Authorization, "Access: application/json;version=2.1"));
    // Url da requisicao
    curl_setopt($ch, CURLOPT_URL, $url);
    // Recebe o json de resposta
    $resultado = curl_exec($ch);
    // Fecha o cURL
    curl_close($ch);
    // Converte a resposta
    $objeto = json_decode($resultado);
    $objeto = $objeto[0];

    $saldo = array(
      'disponivel' => ($objeto->current)/100,
      'indisponivel' => ($objeto->unavailable)/100,
      'futuro' => ($objeto->future)/100
    );

    return $saldo;

  }

  // Saca o dinheiro do moip
  public static function withdraw(Moip $moip, $amount, $bank_number, $agency_number, $agency_check_number, $account_number, $account_check_number, $holder_name, $tax_document){
    try{
      $transfer = $moip->transfers()
      ->setTransfers($amount, $bank_number, $agency_number, $agency_check_number, $account_number, $account_check_number)
      ->setHolder($holder_name, $tax_document)
      ->execute();
      return array(
        'success' => true,
        'transfer' => $transfer->getStatus()
      );
    }
    catch(Exception $e){
      return array(
        'success' => false,
        'error' => $e->__toString()
      );
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      return array(
        'success' => false,
        'error' => $e->__toString()
      );
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      return array(
        'success' => false,
        'error' => $e->__toString()
      );
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      return array(
        'success' => false,
        'error' => $e->__toString()
      );
    }
  }

}
