<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Moip\Moip;
use App\Client;
use DB;

class MoipClient extends Model
{

  const TABLE_NAME = "moip_accounts";

  // Cria um novo cliente através do id do usuário
  public function criarCliente(Moip $moip, $id){
    // Retorna um objeto no formato do cliente
    $data = Client::objetoCliente($id);
    
    if($data == null){
      exit();
    }

    try{
      $customer = $moip->customers()->setOwnId(uniqid())
      ->setFullname($data['nome'] . " " . $data['sobrenome'])
      ->setEmail($data['email'])
      ->setBirthDate($data['aniversario'])
      ->setTaxDocument($data['cpf'])
      ->setPhone($data['ddd'], $data['telefone'])
      ->addAddress('BILLING',
      $data['rua'], $data['numero'],
      $data['bairro'], $data['cidade'], $data['estado'],
      $data['cep'], $data['complemento'])
      ->create();
      $user_id = $data['id'];
      $client_id = $customer->getId();
      // Salva o cliente no banco de dados
      $status = Client::add($user_id, $client_id);
      return true;
    }
    catch(Exception $e){
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401
      echo $e->getMessage();
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
      echo $e->getMessage();
    }
    return false;
  }

  // Pega o ID do cliente moip através do id do usuário
  public static function getClientId($id){
    $customer_id = DB::table(MoipClient::TABLE_NAME)
    ->select('client_id')
    ->where('user_id', $id)
    ->get();

    if(count($customer_id) > 0){
      return $customer_id[0]->client_id;
    }
    else{
      return null;
    }
  }

  // Consulta um cliente pelo seu ID
  public static function consultarCliente(Moip $moip, $customer_id){

    if($customer_id == null){
      return null;
    }

    try{
      $customer = $moip->customers()->get($customer_id);
      return $customer;
    }
    catch(Exception $e){
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401
      echo $e->getMessage();
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
      printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
      echo $e->getMessage();
    }

    return null;
  }

  public static function createClient(Moip $moip, $id){
    $data = Client::objetoCliente($id);

    if($data == null){
      exit();
    }
    
    try{
      $customer = $moip->customers()->setOwnId(uniqid())
          ->setFullname('Fulano de Tal')
          ->setEmail('fulano@email.com')
          ->setBirthDate('1988-12-30')
          ->setTaxDocument('22222222222')
          ->setPhone(11, 66778899)
          ->addAddress('BILLING',
          'Rua de teste', 123,
          'Bairro', 'Sao Paulo', 'SP',
          '01234567', 8)
          ->addAddress('SHIPPING',
          'Rua de teste do SHIPPING', 123,
          'Bairro do SHIPPING', 'Sao Paulo', 'SP',
          '01234567', 8);
      return $customer;
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
        echo $e->getMessage();
    }
    catch (\Moip\Exceptions\ValidationException $e) {
        printf($e->__toString());
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
        echo $e->getMessage();
    }
    return null;
  }

}
