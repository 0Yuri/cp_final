<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Moip\Moip;
use App\Client;
use DB;

class MoipClient extends Model
{

  const TABLE_NAME = "moip_clients";

  // Cria um novo cliente através do id do usuário
  public static function criarCliente(Moip $moip, $data=null){    
    try{
      if($data == null){
        return null;
      }
      else{
        $customer = $moip->customers()->setOwnId(uniqid())
        ->setFullname($data['name'] . " " . $data['last_name'])
        ->setEmail($data['email'])
        ->setBirthDate($data['birthdate'])
        ->setTaxDocument($data['cpf'])
        ->setPhone($data['ddd_1'], $data['tel_1'])
        ->addAddress('BILLING',
        $data['street'], $data['number'],
        $data['neighborhood'], $data['city'], $data['UF'],
        $data['cep'], $data['complement'])
        ->addAddress('SHIPPING',
        $data['street'], $data['number'],
        $data['neighborhood'], $data['city'], $data['UF'],
        $data['cep'], $data['complement'])
        ->create();
        return $customer;
      }
    }
    catch(Exception $e){
    }
    catch (\Moip\Exceptions\UnautorizedException $e) {
      //StatusCode 401     
    }
    catch (\Moip\Exceptions\ValidationException $e) {
      //StatusCode entre 400 e 499 (exceto 401)
    }
    catch (\Moip\Exceptions\UnexpectedException $e) {
      //StatusCode >= 500
    }
    return null;
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
    try{
      if($customer_id == null){
        return null;
      }
      else{
        $customer = $moip->customers()->get($customer_id);
        return $customer;
      }      
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
