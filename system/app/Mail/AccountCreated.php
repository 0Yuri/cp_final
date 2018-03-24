<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class AccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $to;
    protected $account;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $teste)
    {
        $this->account = $teste;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('account_created');
    }
}
