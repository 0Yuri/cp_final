<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\CorreiosError;

class Address extends Model
{
  const TABLE_NAME = "address";

  public static function pegarEntrega($entrega){
    if($entrega['type'] == 'user'){

      $endereco = DB::table(Address::TABLE_NAME)
      ->select('number as numero', 'city as localidade', 'cep', 'UF as uf', 'complement as complemento', 'neighborhood as bairro', 'street as logradouro', 'reference as referencia')
      ->where('user_id', $_SESSION['user_id'])
      ->get();


      if(count($endereco) > 0){
        $endereco = (array)$endereco[0];
        $entrega['info'] = $endereco;
        return $entrega;
      }
      else{
        return "Erro";
      }
    }
    else{
      return $entrega;
    }
  }

  public static function getUserAddress($user_id){
    $endereco = DB::table(User::TABLE_NAME)
    ->select('number as numero', 'city as localidade', 'cep', 'UF as uf', 'complement as complemento', 'neighborhood as bairro', 'street as logradouro', 'reference as referencia')
    ->where('id', $user_id)
    ->get();

    if(count($endereco) > 0){
      return (array)$endereco[0];
    }
    else{
      return null;
    }

  }

  // Salva um endereço
  public static function add($data){
    $adicionou = DB::table(Address::TABLE_NAME)
    ->insert($data);
    //
    if($adicionou){
      return true;
    }else{
      return false;
    }
  }

  // Pega o CEP da loja de acordo com seu ID
  public static function getCepByStore($store_id){
    $cep = DB::table(Store::TABLE_NAME)->select('users.*')
    ->where(Store::TABLE_NAME . '.id', $store_id)
    ->join(User::TABLE_NAME, Store::TABLE_NAME . ".owner_id", '=', User::TABLE_NAME . '.id')
    ->get();

    if(count($cep) > 0){
      return $cep[0]->cep;
    }
    else{
      return null;
    }

    print_r($cep);
  }

  public static function pegarCEP($store_name){
    $cep = DB::table('stores')
    ->select('address.cep')
    ->where('stores.name', '=', $store_name)
    ->join('users', 'users.id', '=', 'stores.owner_id')
    ->join(Address::TABLE_NAME, 'address.user_id', '=', 'users.id')
    ->get();

    if(count($cep) > 0){
      return $cep[0]->cep;
    }
    else{
      return null;
    }
  }
  // Calcula frete de acordo com cep de origem e destinatario + medidas com valor declarado
  public static function calcularFrete($comprador, $cep_origem, $tipo, $weight='1', $height='5', $width='15',$length='16', $declared_price='200'){
    $cep_destino = DB::table(Address::TABLE_NAME)
    ->select('address.cep')
    ->where('users.id', $comprador)
    ->join('users', 'users.id', '=', 'address.user_id')
    ->get();

    return 0;

    if(count($cep_destino) <= 0){
      return 0;
    }

    $cep_destino = $cep_destino[0]->cep;

    $data = array(
      'nCdEmpresa' => '',
      'sDsSenha' => '',
      // CEP DO VENDEDOR
      'sCepOrigem' => $cep_origem,
      // CEP DO COMPRADOR
      'sCepDestino' => $cep_destino,
      // PESO EM KG do pacote
      'nVlPeso' => $weight,
      // 1 para caixa/pacote e 2 para rolo/prisma
      'nCdFormato' => '1',
      // Em centímetros
      'nVlComprimento' => $length,
      'nVlAltura' => $height,
      'nVlLargura' => $width,
      'nVlDiametro' => '0',
      'sCdMaoPropria' => 's',
      // Valor da encomenda caso de extravio
      'nVlValorDeclarado' => $declared_price,
      'sCdAvisoRecebimento' => 'n',
      'StrRetorno' => 'xml',
      // SEDEX e PAC
      'nCdServico' => '40010,41106'
    );

    $data = http_build_query($data);
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";
    $curl = curl_init($url . '?' . $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $result = simplexml_load_string($result);
    $fretes = array();

    $envio = array(
      'sedex' => 0,
      'pac' => 0
    );

    foreach($result as $servico){
      if((String)$servico->Codigo == '40010'){
        $envio['sedex'] = $servico->Valor;
        $fretes['SEDEX'] = array(
          'valor' => (String)$servico->Valor,
          'prazo' => (String)$servico->PrazoEntrega
        );
      }else{
        $envio['pac'] = $servico->Valor;
        $fretes['PAC'] = array(
          'valor' => (String)$servico->Valor,
          'prazo' => (String)$servico->PrazoEntrega
        );
      }
    }

    if($tipo == "sedex"){
      return $envio['sedex'] * 100;
    }
    else{
      return $envio['pac'] * 100;
    }
  }

  public static function calculateValues($cep_origem, $cep_destino, $peso, $dimensao, $preco_declarado = '0'){
    $altura = $largura = $comprimento = $dimensao;
    // Altura
    if($altura < 2){
      $altura = 2;
    }
    else if($altura > 105){
      $altura = 105;
    }
    // Largura
    if($largura < 11){
      $largura = 11;
    }
    // Comprimento
    if($comprimento < 18){
      $comprimento = 18;
    }
    else if($comprimento > 105){
      $comprimento = 105;
    }

    $data = array(
      'nCdEmpresa' => '',
      'sDsSenha' => '',
      // CEP DO VENDEDOR
      'sCepOrigem' => $cep_origem,
      // CEP DO COMPRADOR
      'sCepDestino' => $cep_destino,
      // PESO EM KG do pacote
      'nVlPeso' => $peso,
      // 1 para caixa/pacote e 2 para rolo/prisma
      'nCdFormato' => '1',
      // Em centímetros
      'nVlComprimento' => $comprimento,
      'nVlAltura' => $altura,
      'nVlLargura' => $largura,
      'nVlDiametro' => '0',
      'sCdMaoPropria' => 's',
      // Valor da encomenda caso de extravio
      'nVlValorDeclarado' => '0',
      'sCdAvisoRecebimento' => 'n',
      'StrRetorno' => 'xml',
      // SEDEX=40010 e PAC=41106
      'nCdServico' => '40010,41106'
    );
    $data = http_build_query($data);
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";
    $curl = curl_init($url . '?' . $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $result = simplexml_load_string($result);

    $fretes = array();

    foreach($result as $servico){
      $valor = (float)$servico->Valor;
      $prazo = (int)$servico->PrazoEntrega;
      $erro_code = (String)$servico->Erro;
      $erro_msg = (String) $servico->MsgErro;
      if((String)$servico->Codigo == '40010'){
        $fretes['SEDEX'] = array(
          'valor' => $valor,
          'prazo' => $prazo,
          'erro_code' => $erro_code,
          'error_msg' => CorreiosError::tratarErro($erro_code)
        );
      }else{
        $fretes['PAC'] = array(
          'valor' => $valor,
          'prazo' => $prazo,
          'erro_code' => $erro_code,
          'error_msg' => CorreiosError::tratarErro($erro_code)
        );
      }
    }

    return $fretes;
  }
}
