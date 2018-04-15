<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SoldProduct extends Mailable
{
    use Queueable, SerializesModels;

    public $products;
    public $seller_name;
    public $buyer_name;
    public $subject = "Você realizou uma venda.";

    public function __construct($produtos, $nome_vendedor, $nome_comprador)
    {
        $this->products = $produtos;
        $this->seller_name = $nome_vendedor;
        $this->buyer_name = $nome_comprador;
    }

    public function build()
    {
        return $this->view('soldproduct');
    }
}
