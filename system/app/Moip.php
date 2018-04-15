<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moip extends Model
{
    /* ATENÇÃO
     * Token da aplicação - Mudar aqui mudará todo na aplicação
     * Note que ao mudar, contas criadas com outro token não serão acessíveis
     * Em ambiente de testes, delete as informações da DB após mudar o token
     */
    const ACCESS_TOKEN = "a4face756e9e4e5c977b0b6449d4e168_v2";
    /*
     * ID da conta moip do dono da aplicação
     */
    const OWNER_ACCOUNT = "MPA-B4ABF9C3ED72";
    /*
     * Endereços de redirecionamento após pedidos.
     */
    const SUCCESS_LINK = "localhost/pedidofinalizado";
    const FAILED_LINK = "localhost/erropedido";
}
