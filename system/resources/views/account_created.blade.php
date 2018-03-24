<header>
    <img class="img-circle" src="../resources/assets/images/logo.png" alt="teste" width="auto" height="250px">
</header>


<h4>Olá, {{$nome}}</h4>

<p>Você se cadastrou no nosso site, mas falta ativar sua conta para poder usufruir de todos os nossos serviços</p>

<h4><b>Para ativar sua conta, basta clicar no link ou copiá-lo e abrir em seu navegador:</b></h4>

<a target="_blank" href="{{$unique_token}}">{{$unique_token}}</a>

<footer>
    <p>Atenciosamente, Equipe Crescendo e Passando</p>
    <p>Todos os direitos reservados. 2018</p>
</footer>