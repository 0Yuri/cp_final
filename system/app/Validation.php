<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Validation extends Model
{
  protected $message;
  protected $pattern;

  public function __construct(){
    $this->message = "";
  }

  // Avalia todos os campos setados e valida o conteúdo
  public function validateAll($data){
    // Nome
    if(isset($data['name'])){
      $this->message .= $this->validarNomes($data['name']);
    }

    // Sobrenome
    if(isset($data['last_name'])){
      $this->message .= $this->validarNomes($data['last_name'], "Sobrenome");
    }

    // Email
    if(isset($data['email'])){
      $this->message .= $this->validarEmail($data['email']);
    }

    // Emissor
    if(isset($data['issuer'])){
      $this->message .= $this->validarEmissor($data['issuer']);
    }

    if(isset($data['issue_date'])){}

    // Gender
    if(isset($data['gender'])){
      $this->message .= $this->validarGender($data['gender']);
    }

    // CPF
    if(isset($data['cpf'])){
      $this->message .= $this->validarCPF($data['cpf']);
    }

    // CNPJ
    if(isset($data['cnpj'])){
      $this->message .= $this->validarCNPJ($data['cnpj']);
    }

    // RG
    if(isset($data['rg'])){
      $this->message .= $this->validarRG($data['rg']);
    }

    // Birthdate
    if(isset($data['birthdate'])){
      $this->message .= $this->validarBirthdate($data['birthdate']);
    }

    // DDDs
    if(isset($data['ddd_1'])){
      $this->message .= $this->validarDDD($data['ddd_1']);
    }

    // Opcional
    if(isset($data['ddd_2'])){
      $this->message .= $this->validarDDD($data['ddd_2'], "opcional");
    }

    // Telefones
    if(isset($data['tel_1'])){
      $this->message .= $this->validarTelefone($data['tel_1']);
    }

    // Telefone Opcional
    if(isset($data['tel_2'])){
      $this->message .= $this->validarTelefone($data['tel_2'], "opcional");
    }

    // CEP
    if(isset($data['cep'])){
      $this->message .= $this->validarCEP($data['cep']);
    }

    // Rua
    if(isset($data['street'])){
      $this->message .= $this->validarRua($data['street']);
    }

    // Cidade
    if(isset($data['city'])){
      $this->message .= $this->validarCidade($data['city']);
    }

    // Estado
    if(isset($data['UF'])){
      $this->message .= $this->validarEstado($data['UF']);
    }

    // Número
    if(isset($data['number'])){
      $this->message .= $this->validarNumero($data['number']);
    }

    // Bairro
    if(isset($data['neighborhood'])){
      $this->message .= $this->validarBairro($data['neighborhood']);
    }

    // Complemento
    if(isset($data['complement'])){
      $this->message .= $this->validarComplemento($data['complement']);
    }

    if(isset($data['reference'])){
      $this->message .= $this->validarReferencia($data['reference']);
    }

    return $this->message;
  }

  public function validarNomes($nome, $info="nome"){
    if(preg_match("/^[a-zA-Z ]{1,}$/", $nome)){
      return "";
    }
    else{
      return "O campo de " . $info . " está inválido.";
    }
  }

  public function validarEmail($email){
    // ^[a-z]{1}([a-z]*|[0-9]*|[\w]*)
    // @[a-z]{1,}.([a-z]{1,})*(c{1}o{1}m{1})(.b{1}r{1})*$
    if(preg_match("/^[a-z]{1}([a-z]*|[0-9]*|[\w]*)@[a-z]{1,}.([a-z]{1,})*(c{1}o{1}m{1})(.b{1}r{1})*$/", $email)){
      return "";
    }
    else{
      return "O campo de email está inválido.";
    }
  }

  public function validarEmissor($emissor){
    if(preg_match("/^[a-zA-Z]+$/", $emissor)){
      return "";
    }
    else{
      return "O campo do emissor está inválido.";
    }
  }

  public function validarGender($sexo){
    if($sexo != "male" && $sexo != "female"){
      return "O campo de gênero/sexo está inválido.";
    }
    else{
      return "";
    }
  }

  public function validarCPF($cpf){
    // Com pontos e traços
    // if(preg_match("/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/", $cpf)){
    // Sem pontos e traços
    if(preg_match("/^[0-9]{11}$/", $cpf)){
      return "";
    }
    else{
      return "O campo de CPF está inválido.";
    }
  }

  public function validarCNPJ($cnpj){
    if(preg_match("/^[0-9]{2}.[0-9]{3}.[0-9]{3}\/[0-9]{4}-[0-9]{2}$/" , $cnpj)){
      return "";
    }
    else{
      return "O campo de cnpj está inválido.";
    }
  }

  public function validarRG($rg){
    // Com pontos
    // if(preg_match("/^[0-9]{1}.[0-9]{3}.[0-9]{3}$/", $rg)){
    // Sem pontos
    if(preg_match("/^[0-9]{7}$/", $rg)){
      return "";
    }
    else{
      return "O campo de RG está inválido.";
    }
  }

  public function validarAniversario($aniversario){

  }

  public function validarDDD($ddd, $info="principal"){
    if(preg_match("/^[0-9]{2}$/", $ddd)){
      return "";
    }
    else{
      return "O campo de DDD do telefone " . $info . " está inválido.";
    }
  }

  public function validarTelefone($phone, $info="principal"){
    if(preg_match("/^[0-9]{8,9}$/", $phone)){
      return "";
    }
    else{
      return "O Campo telefone " . $info . " está inválido.";
    }
  }

  public function validarCEP($cep){
    if(preg_match("/^[0-9]{5}-[0-9]{3}$/", $cep)){
      return "";
    }
    else{
      return "O campo do CEP está inválido.";
    }
  }

  public function validarRua($rua){
    // if(preg_match("/^[a-zA-Z]{1}([a-zA-Z]+|\ )+$/", $rua)){
    if(preg_match("/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{1,}$/", $rua)){
      return "";
    }
    else{
      return "O campo rua está inválido.";
    }
  }

  public function validarCidade($cidade){
    if(preg_match("/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{1,}$/", $cidade)){
      return "";
    }
    else{
      return "O campo cidade está inválido.";
    }
  }

  public function validarEstado($uf){
    if(preg_match("/^[a-zA-Z]{2,3}$/", $uf)){
      return "";
    }
    else{
      return "O campo UF/Estado está inválido.";
    }
  }

  public function validarNumero($numero){
    if(preg_match("/^[0-9]+$/", $numero)){
      return "";
    }
    else{
      return "O campo número está inválido.";
    }
  }

  public function validarBairro($bairro){
    if(preg_match("/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ 0-9]{1,}$/", $bairro)){
      return "";
    }
    else{
      return "O campo bairro está inválido.";
    }
  }

  public function validarComplemento($complemento){
    if(preg_match("/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ 0-9]{1,}$/", $complemento)){
      return "";
    }
    else{
      return "O campo complemento está inválido.";
    }
  }

  public function validarReferencia($referencia){
    if(preg_match("/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ 0-9]{1,}$/", $referencia)){
      return "";
    }
    else{
      return "O campo referencia está inválido.";
    }
  }

  public function validateBadWords($field){
    $symbol = array(
      '*', '/', '.',
      ',', '+', '-',
      '@', '#', '$',
      '|', ';', ':',
      '"', '[', '{',
      '}', ']', '=',
      '-', '&', '^',
      '~', '`', '?'
    );
    $bad_words = array(
      'pussy', 'sex', 'blowjob',
      'dick', 'anal', 'putaria',
      'orgia', 'gay', 'transar',
      'pau', 'piroca', 'rola',
      'caralho', 'cu', 'anl'
    );

    // Remove possíveis números
    for($i = 0; $i < 10; $i++){
      $field = str_ireplace($i,"",$field);
    }

    // Remove símbolos
    foreach($symbol as $sym){
      $field = str_ireplace($sym, "", $field);
    }

    // verifica palavrões presentes
    foreach($bad_words as $word){
      if(strlen(stristr($field, $word)) > 0){
        return "Um campo possui mensagens ofensivas.!";
      }
    }

    return "";
  }

  // Valida um CPF para cadastro
  public function validateCPFValues($cpf){
    $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
    // Valida tamanho
    if (strlen($cpf) != 11){
      return false;
    }

    if($cpf == '00000000000' ||
    $cpf == '11111111111' ||
    $cpf == '22222222222' ||
    $cpf == '33333333333' ||
    $cpf == '44444444444' ||
    $cpf == '55555555555' ||
    $cpf == '66666666666' ||
    $cpf == '77777777777' ||
    $cpf == '88888888888' ||
    $cpf == '99999999999'){
      return false;
    }

    // Calcula e confere primeiro dígito verificador
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--){
      $soma += $cpf{$i} * $j;
    }

    $resto = $soma % 11;

    if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto)){
      return false;
    }

    // Calcula e confere segundo dígito verificador
    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--){
      $soma += $cpf{$i} * $j;
    }

    $resto = $soma % 11;

    return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
  }

  // Valida se o usuário logado é administrador
  public static function validateAdmin($id){
    $user = DB::table('users')
    ->select('users.account_type')
    ->where('users.id', $_SESSION['user_id'])
    ->get();

    if(count($user) > 0 && $user[0]->account_type = 'admin'){
      return true;
    }
    else{
      return false;
    }
  }
}
