<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;


    public $order_id;
    public $tracking_code;
    public $buyer_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $track_code, $buyer_name)
    {
        $this->order_id = $order_id;
        $this->tracking_code = $track_code;
        $this->buyer_name = $buyer_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('ordershipped');
    }
}
