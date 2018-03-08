<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Moip\Moip;
use DateTime;
use DateInterval;

class MoipPayment extends Model
{

  const logo_uri = "http://www.crescendoepassando.com.br/public/img/site/header/logo.png";
  const instruction_lines = ["Atenção,", "fique atento à data de vencimento do boleto.", "Pague em qualquer casa lotérica."];

  // Gerar holder do cartão de crédito
  public static function gerarHolder(Moip $moip, $data){
    try{
      $holder = $moip->holders()->setFullname($data['name'] . " " .  $data['last_name'])
      ->setBirthDate($data['aniversario'])
      ->setTaxDocument($data['cpf'], 'CPF')
      ->setPhone($data['ddd'], $data['telefone'], 55)
      ->setAddress('BILLING', $data['street'], $data['number'], $data['neighborhood'], $data['city'], $data['UF'], $data['cep'], $data['complement']);
      return $holder;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
    return null;
  }

  // MULTIPEDIDO

  // Boleto
  public static function pagarBoletoMulti($multiorder){
    try{
      $expiration_date = new DateTime();
      // Adiciona 3 dias
      $expiration_date->add(new DateInterval('P03D'));
      $instruction_lines = ["Atenção,", "fique atento à data de vencimento do boleto.", "Pague em qualquer casa lotérica."];

      $payment = $multiorder->multipayments()
      ->setBoleto($expiration_date, MoipPayment::logo_uri, MoipPayment::instruction_lines)
      ->execute();
      return $payment;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
    return null;
  }
  // Cartão
  public static function pagarCartaoMulti($multiorder, $holder, $number_cc, $cvc, $expiration_year, $expiration_month, $parcelas=1){
    try{
      $store_cc = true;
      $payment = $multiorder->multipayments()
      ->setCreditCard($expiration_month, $expiration_year,$number_cc, $cvc, $customer, $store_cc)
      ->setInstallmentCount($parcelas)
      ->setStatementDescriptor('CresPass')
      ->setDelayCapture(false)
      ->execute();
      return $payment;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
    return null;
  }

  // SIMPLES

  // Boleto
  public static function pagarBoletoSimples($order){
    try{
      $expiration_date = new DateTime();
      // Adiciona 3 dias
      $expiration_date->add(new DateInterval('P03D'));
      $instruction_lines = ["Atenção,", "fique atento à data de vencimento do boleto.", "Pague em qualquer casa lotérica."];

      $payment = $order->payments()
          ->setBoleto($expiration_date, MoipPayment::logo_uri, MoipPayment::instruction_lines)
          ->setStatementDescriptor("CresPass")
          ->execute();

      return $payment;
    }
    catch (Exception $e){
      print_r($e->__toString());
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
    return null;
  }
  // Cartão
  public static function pagarCartaoSimples($order, $holder, $number_cc, $cvc, $expiration_year, $expiration_month, $parcelas=1){
    try{
      $store_cc = true;
      $payment = $order->payments()
      ->setCreditCard($expiration_month, $expiration_year, $number_cc, $cvc, $holder, $store_cc)
      ->setInstallmentCount($parcelas)
      ->setStatementDescriptor('CresPass')
      ->execute();
      return $payment;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
    return null;
  }

  // Extra
  public static function pagarDebitoMulti($multiorder){
    try {
      $bank_number = '001';
      $return_uri = 'https:://www.crescendoepassando.com.br';
      $expiration_date = new DateTime();
      $payment = $multiorder->multipayments()
      ->setOnlineBankDebit($bank_number, $expiration_date, $return_uri)
      ->execute();

      return $payment;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
    return null;
  }

  public static function pagarDebitoSimples($order){
    try {
      $bank_number = '001';
      $return_uri = 'https://moip.com.br';
      $expiration_date = new DateTime();
      $payment = $order->payments()
      ->setOnlineBankDebit($bank_number, $expiration_date, $return_uri)
      ->execute();
      return $payment;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      print_r($e->getMessage());
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      print_r($e->getMessage());
    }
    return null;
  }

}
