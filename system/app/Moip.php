<?php

namespace App;

use Moip\Moip;

class Moip
{
    /* ATENÇÃO
     * Token da aplicação - Mudar aqui mudará em todos os campso na aplicação
     * Note que ao mudar, contas criadas com outro token não serão acessíveis
     * Em ambiente de testes, delete as informações da DB após mudar o token
     */
    
    const APP_ID = "APP-XUMYN4OD5VAW";
    const URL = "http://www.crescendoepassando.com.br/";
    const ACCESS_TOKEN = "d89cab025a284d25923e1e0fce147103_v2";    
    const REDIRECT_URL = "http://www.crescendoepassando.com.br/getmoip/"; //url que deve tratar o retorno do moip
    const SECRET_SERIAL = "a388e4f5dd9e4ddea42cad4d5c72ebbc";
    const SUCCESS_LINK = "http://localhost/pedidofinalizado";
    const FAILED_LINK = "http://localhost/erropedido";

    // const MOIP_ENVIRONMENT = Moip::ENDPOINT_PRODUCTION;
    // const MOIP_CONNECT_ENV = Connect::ENDPOINT_PRODUCTION;

    // Negocial
    const SELLER_AMOUNT = 80;
    const CP_AMOUNT = 20;
    const OWNER_ACCOUNT = "MPA-443B8CF85041"; //ID da conta moip do dono da aplicação


    const TOKEN_MOIP = "DEYSLZFR42KBXZWS4YS1IPMOFPMEI4BI";
    const KEY_MOIP = "W2CIISZXA8H5GHRZOBYSJXL6IALX8DTMH9BURBQR";
    const PUBLIC_KEY_MOIP = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAn3zeIBCv8CRY2/x8IroH
aM8I0fq2hk4ppiBbIaOXab9Zx7UabAY0bk6Gn8yRnd/Omb3E7jR9SuQFXlhTJubg
8a5hwWh/WAyUi4kv4beSMMeiVxkQrlSwSbCkhU4yW4I6O1rzvPbXjA9QMAEol5xc
AysIbTSpLJ5kXbpq8XZQNJrBJvcU5MJIdnDbOrw/4W8RUpusJwnVICfXO8dwooPK
xi2zg1Y1FFrW2PyAneZyJlFguV6mRFjlJaeemM3aajKJ0MDW/+gNNkdTOJg8L4eh
TYRnS8CCs25l0HCYt4VxzI/kNcI50pgJ2VkHAt5TBrwJyhFKhTgqoWDz56jGi1FG
qwIDAQAB
-----END PUBLIC KEY-----";


    /*
    {
    "id": "APP-XUMYN4OD5VAW",
    "website": "http://www.crescendoepassando.com.br",
    "accessToken": "d89cab025a284d25923e1e0fce147103_v2",
    "description": "Brecho infantil",
    "name": "Crescendo e Passando",
    "secret": "a388e4f5dd9e4ddea42cad4d5c72ebbc",
    "redirectUri": "http://www.crescendoepassando.com.br/getmoip/",
    "createdAt": "2018-09-15T01:41:20.877Z",
    "updatedAt": "2018-09-15T01:41:20.877Z"
    }
    */
}
