<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    // Valor base de sucesso
    const SUCCESS_STATUS = TRUE;
    // Mensagem de erro base
    const MSG_ERROR = "";

    protected $data;

    public function __construct(){
        $this->data = [
            'success' => self::SUCCESS_STATUS,
            'error' => self::MSG_ERROR,
            'object' => array()
        ];
    }

    public function setSuccess($success=self::SUCCESS_STATUS){
        $this->data['success'] = $success;
    }

    public function setMsgError($msg_error=self::MSG_ERROR){
        $this->data['error'] = $msg_error;
    }

    public function setObject($object=null){
        $this->data['object'] = $object;
    }

    public function setFailed($msg_error=""){
      $this->data['success'] = FALSE;
      $this->data['error'] = $msg_error;
    }

    public function get(){
        return [
          'success' => $this->data['success'],
          'error' => $this->data['error'],
          'object' => $this->data['object']];
    }

}
