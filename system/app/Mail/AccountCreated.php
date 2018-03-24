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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $token)
    {
        $this->nome = $nome;
        $this->unique_token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('accountcreated')
        ->to("yves_henry13@hotmail.com", "Yves")
        ->subject("teste");
    }
}
