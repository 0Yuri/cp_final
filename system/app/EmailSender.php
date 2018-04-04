<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\Mail\OrderCreated;
use App\Mail\OrderShipped;
use App\Mail\SoldProduct;

use App\Activation;

use DB;

class EmailSender extends Model
{
    public static function enviarContaCriada($user_id, $email, $username){
        $string = password_hash($user_id, PASSWORD_BCRYPT);
        $string = str_ireplace("$", "", $string);

        $data = array(
            'user_id' => $user_id,
            'token' => $string
        );

        $added = Activation::saveActivation($data);

        if($added){
            // Mail::to($email)->send(new AccountCreated($username, 'http://www.crescendoepassando.com.br/ativarconta/'.$string));
            Mail::to($email)->send(new AccountCreated($username, 'http://localhost/ativarconta/'.$string));
            return true;
        }
        else{
            return false;
        }
    }

    public static function enviarPedidoCriado($order_id, $username, $pedido, $email){
        Mail::to($email)->send(new OrderCreated($order_id, $username, $pedido));
    }

    public static function enviarProdutosVendidos($produtos, $vendedor, $comprador, $email){
        Mail::to($email)->send(new SoldProduct($produtos, $vendedor, $comprador));
    }

    public static function enviarPedidoEnviado($order_id, $cod_rastreio, $comprador, $email){
        Mail::to($email)->send(new OrderShipped($order_id, $cod_rastreio, $comprador));
    }

}
