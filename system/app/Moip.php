<?php

namespace App;

class Moip
{
    /* ATENÇÃO
     * Token da aplicação - Mudar aqui mudará em todos os campso na aplicação
     * Note que ao mudar, contas criadas com outro token não serão acessíveis
     * Em ambiente de testes, delete as informações da DB após mudar o token
     */
    const ACCESS_TOKEN = "0c832c6380f344bf9c1e1c3c3bf712fa_v2";
    const APP_ID = "APP-DY5IMOZNBVXT";
    const URL = "http://localhost/";
    const REDIRECT_URL = "http://localhost/getmoip/"; //url que deve tratar o retorno do moip
    const SECRET_SERIAL = "47a3dd45805340ec95a9260faecbc68a";
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

    /* GERADO PARA TESTES
    {
  "id": "APP-DY5IMOZNBVXT",
  "website": "http://localhost",
  "accessToken": "0c832c6380f344bf9c1e1c3c3bf712fa_v2",
  "description": "E-commerce de produtos infantis",
  "name": "Crescendo e Passando",
  "secret": "47a3dd45805340ec95a9260faecbc68a",
  "redirectUri": "http://localhost/getmoip/",
  "createdAt": "2018-08-16T01:17:08.187Z",
  "updatedAt": "2018-08-16T01:17:08.187Z"
}
    */
}
