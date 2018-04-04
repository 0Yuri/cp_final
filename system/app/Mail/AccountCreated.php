<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $unique_token;
    public $subject = "Link de ativação da sua conta - Crescendo e Passando";

    public function __construct($nome, $token)
    {
        $this->nome = $nome;
        $this->unique_token = $token;
    }

    public function build()
    {
        return $this->view('accountcreated');
    }
}
