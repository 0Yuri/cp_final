<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;
    
    public $order_id;
    public $subject;
    public $name;
    public $order;

    public function __construct($orderId, $username, $pedido)
    {
        $this->order_id = $orderId;
        $this->subject = "O pedido " . $orderId . " foi criado com sucesso.";
        $this->name = $username;
        $this->order = $pedido;
    }
    
    public function build()
    {
        return $this->view('ordercreated');
    }
}
