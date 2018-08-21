<?php

namespace App;

class Moip
{
    /* ATENÇÃO
     * Token da aplicação - Mudar aqui mudará em todos os campso na aplicação
     * Note que ao mudar, contas criadas com outro token não serão acessíveis
     * Em ambiente de testes, delete as informações da DB após mudar o token
     */
    const ACCESS_TOKEN = "7992fc93022a4f88840118f59aadc782_v";
    const APP_ID = "APP-PNFT400XDNCY";
    const URL = "http://www.crescendoepassando.com.br/";
    const REDIRECT_URL = "http://www.crescendoepassando.com.br/getmoip/"; //url que deve tratar o retorno do moip
    const SECRET_SERIAL = "0317e6963e9f4919805fd0d44b2a5b17";
    const SUCCESS_LINK = "http://localhost/pedidofinalizado";
    const FAILED_LINK = "http://localhost/erropedido";

    // Negocial
    const SELLER_AMOUNT = 80;
    const CP_AMOUNT = 20;
    const OWNER_ACCOUNT = "MPA-B4ABF9C3ED72"; //ID da conta moip do dono da aplicação


    const TOKEN_MOIP = "16NT59QVI4RBR59RPSQ9790K3MXKYWMN";
    const KEY_MOIP = "0DPJFLVWNMJD0O5YTMXVIBDCJDK6XKEKER2YVDTX";
    const PUBLIC_KEY_MOIP = "-----BEGIN PUBLIC KEY-----
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnn0BRekMnGuLyfLAFQxA
    t0qob4qSwuHHAY4LqhdW6V+VZAsqs66xWJmjsjjeXsp+F17HfgxpHbOUqfyTy1EF
    7d9MtXk8kpAAqMAJNXDFGdAvj6eHSvsNyvhhq5SsK5U+HS2WYbBIUs5vDrNhyCSM
    18f2A/N5LYTNqP7HPDZM2WbEEQtyp308RXsXw2w46qjPVxTllBOrC3zc5LSEG8gj
    2igV3R7aqDb1wnkmqdKB8Lhwwrz5RMoN5+HmYzj2g0StQT70m5zhSTPpxWgWz44d
    VUr10Cs+B4g4ezRZ0LFa5afS1ZXxuoXa0G1d2/KGNMer8SpDVPf1wbg9nhcmK2QE
    mQIDAQAB
    -----END PUBLIC KEY-----";


    /*
    {
        "id": "APP-PNFT400XDNCY",
        "website": "http://www.crescendoepassando.com.br",
        "accessToken": "7992fc93022a4f88840118f59aadc782_v2",
        "description": "E-commerce de roupas infantis",
        "name": "Crescendo e Passando",
        "secret": "0317e6963e9f4919805fd0d44b2a5b17",
        "redirectUri": "http://www.crescendoepassando.com.br/getmoip/",
        "createdAt": "2018-08-21T02:31:26.256Z",
        "updatedAt": "2018-08-21T02:31:26.256Z"
    } */
}
