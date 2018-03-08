<?php

namespace App\Http\Controllers;

use Jarouche\ViaCEP\BuscaViaCEPJSONP;

class CorreiosController extends Controller
{

    public function calcular_frete(){
      // $dados = $this->get_post();
      $data = array(
        'nCdEmpresa' => '',
        'sDsSenha' => '',
        // CEP DO VENDEDOR
        'sCepOrigem' => '43820080',
        // CEP DO COMPRADOR
        'sCepDestino' => '50721200',
        // 'sCepDestino' => $dados['number'],
        // PESO EM KG do pacote
        'nVlPeso' => '1',
        // 1 para caixa/pacote e 2 para rolo/prisma
        'nCdFormato' => '1',
        // Em centímetros
        'nVlComprimento' => '16',
        'nVlAltura' => '5',
        'nVlLargura' => '15',
        'nVlDiametro' => '0',
        'sCdMaoPropria' => 's',
        // Valor da encomenda caso de extravio
        'nVlValorDeclarado' => '200',
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
            'valor' => (String)$servico->Valor,
            'prazo' => (String)$servico->PrazoEntrega
          );
        }else{
          $fretes['PAC'] = array(
            'valor' => (String)$servico->Valor,
            'prazo' => (String)$servico->PrazoEntrega
          );
        }
      }

      $this->return->setObject($fretes);

    }

    public function pegarEndereco(){
      $data = $this->get_post();
      $data = $data['info'];
      $class = new BuscaViaCEPJSONP();
      $result = $class->retornaCEP($data->cep);

      if(isset($result['erro']) && $result['erro'] == 1){
        $this->return->setFailed("Ocorreu um erro com o cep. Favor digite o endereço manualmente.");
      }
      else if(count($result) <= 0){
        $this->return->setFailed("Ocorreu um erro com o cep. Favor digite o endereço manualmente.");
      }
      else{
        $this->return->setObject($result);
      }
    }

    public function pegarEnderecoCadastro(){
      $data = $this->get_post();
      $data = $data['cep'];
      $class = new BuscaViaCEPJSONP();
      $result = $class->retornaCEP($data);

      if(isset($result['erro']) && $result['erro'] == 1){
        $this->return->setFailed("Ocorreu um erro com o cep. Favor digite o endereço manualmente.");
      }
      else if(count($result) <= 0){
        $this->return->setFailed("Ocorreu um erro com o cep. Favor digite o endereço manualmente.");
      }
      else{
        $resultado = array(
          'cep' => $result['cep'],
          'street' => $result['logradouro'],
          'neighborhood' => $result['bairro'],
          'city' => $result['localidade'],
          'UF' => $result['uf'],
          'complement' => $result['complemento']
        );
        $this->return->setObject($resultado);
      }
    }

}
