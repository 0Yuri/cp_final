<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Address extends Model
{

  public static function pegarEntrega($entrega){
    if($entrega['type'] == 'user'){

      $endereco = DB::table('address')
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

  public static function pegarEndereco($id){
    $endereco = DB::table('address')
    ->select('number as numero', 'city as localidade', 'cep', 'UF as uf', 'complement as complemento', 'neighborhood as bairro', 'street as logradouro', 'reference as referencia')
    ->where('user_id', $id)
    ->get();

    if(count($endereco) > 0){
      return (array)$endereco[0];
    }
    else{
      return null;
    }

  }
  // Salva um endereço
  public static function salvar($data){
    $adicionou = DB::table('address')
    ->insert($data);
    //
    if($adicionou){
      return true;
    }else{
      return false;
    }
  }
  // Pega o CEP da loja de acordo com seu ID
  public static function getCEP($store_id){
    $cep = DB::table('stores')
    ->select('address.cep')
    ->where('stores.id', '=', $store_id)
    ->join('users', 'users.id', '=', 'stores.owner_id')
    ->join('address', 'address.user_id', '=', 'users.id')
    ->get();

    if(count($cep) > 0){
      return $cep[0]->cep;
    }
    else{
      return null;
    }
  }

  public static function pegarCEP($store_name){
    $cep = DB::table('stores')
    ->select('address.cep')
    ->where('stores.name', '=', $store_name)
    ->join('users', 'users.id', '=', 'stores.owner_id')
    ->join('address', 'address.user_id', '=', 'users.id')
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
    $cep_destino = DB::table('address')
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

  public static function calcularValores($cep_origem, $cep_destino, $peso, $dimensao, $preco_declarado = '0'){
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
    if($comprimento < 16){
      $comprimento = 16;
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

    foreach($result as $servico){
      if((String)$servico->Codigo == '40010'){
        $fretes['SEDEX'] = array(
          'valor' => (float)$servico->Valor,
          'prazo' => (int)$servico->PrazoEntrega
        );
      }else{
        $fretes['PAC'] = array(
          'valor' => (float)$servico->Valor,
          'prazo' => (int)$servico->PrazoEntrega
        );
      }
    }

    return $fretes;
  }
}
