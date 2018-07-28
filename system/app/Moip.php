<?php

namespace App;

class Moip
{
    /* ATENÇÃO
     * Token da aplicação - Mudar aqui mudará em todos os campso na aplicação
     * Note que ao mudar, contas criadas com outro token não serão acessíveis
     * Em ambiente de testes, delete as informações da DB após mudar o token
     */
    const ACCESS_TOKEN = "c42b3b50aa2642ec9fdad8bebd30425e_v2";
    const APP_ID = "APP-0BHRHHL451CS";
    const URL = "http://localhost/";
    const REDIRECT_URL = "http://localhost/system/public/moip/receive/"; //url que deve tratar o retorno do moip
    const SECRET_SERIAL = "78608a48596f4753900bec7c647e1bb3";
    const OWNER_ACCOUNT = "MPA-B4ABF9C3ED72"; //ID da conta moip do dono da aplicação
    const SUCCESS_LINK = "localhost/pedidofinalizado";
    const FAILED_LINK = "localhost/erropedido";
    /* GERADO PARA TESTES
    {
        "id": "APP-0BHRHHL451CS",
        "website": "http://localhost/",
        "accessToken": "c42b3b50aa2642ec9fdad8bebd30425e_v2",
        "description": "Ecommerce brecho infantil",
        "name": "crespass",
        "secret": "78608a48596f4753900bec7c647e1bb3",
        "redirectUri": "http://localhost/system/public/moip/receive/",
        "createdAt": "2018-07-21T03:05:04.290Z",
        "updatedAt": "2018-07-21T03:05:04.290Z"
    }
    */
}
