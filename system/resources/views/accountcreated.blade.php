<html>
  <style>
    .row{
      width:100%;
      float:left;
    }
    .col{
      width:25%;
      float:left;
    }
  </style>
  <body>
  <div class="row">
    <div class="col">
    <p></p>
    </div>
    <div class="col">
    <img src="http://www.crescendoepassando.com.br/public/img/site/header/logo.png" alt="teste" width="auto" height="250px">
    </div>
  </div>
  <div class="row">
    <div class="col"><p></p></div>
    <div class="col">
      <h4>Olá, {{$nome}}</h4>
      <p>Você se cadastrou no nosso site, mas falta ativar sua conta para poder usufruir de todos os nossos serviços</p>
      <h4><b>Para ativar sua conta, basta clicar no link ou copiá-lo e abrir em seu navegador:</b></h4>
      <a target="_blank" href="{{$unique_token}}">{{$unique_token}}</a>
    </div>
  </div>
  <div class="row">
    <div class="col"><p></p></div>
    <div class="col">
      <p>Atenciosamente, Equipe Crescendo e Passando</p>
      <p>Todos os direitos reservados. 2018</p>
    </div>
  </body>
</html>