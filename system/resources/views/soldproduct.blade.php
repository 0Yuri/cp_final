<html>
  <style>
    .row{
      width:100%;
      float:left;
    }
    .capitalizar{
        text-transform:capitalize;
    }
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding:8px
    }
    tr:nth-child(even) {
        background-color: #dddddd;
    }
  </style>
  <body>
  <div class="row">
    <img src="http://www.crescendoepassando.com.br/public/img/site/header/logo.png" alt="teste" width="auto" height="250px">
  </div>
  <div class="row">
    <div class="row">
      <h4 class="capitalizar">olá, {{$seller_name}}!</h4>
    </div>
    <div class="row">
     <h4>O usuário {{$buyer_name}} realizou uma compra na sua loja dos seguintes produtos</h4>
    </div>
    <div class="row">
        <table>
        <tr>
            <th>Nome do produto</th>
            <th>Quantidade</th>
            <th>Preço</th>
        </tr>
        @foreach ($products as $produto)
        <tr>
            <th>{{$produto['nome']}}</th>
            <th>{{$produto['quantidade']}}</th>
            <th>
            <?php 
                echo "R$ "  . number_format($produto['quantidade'] * $produto['preco'], 2, ',', '.');
            ?>
            </th>
        </tr>
        @endforeach
        </table>
    </div>
  </div>
  <div class="row">
      <p>Atenciosamente, Equipe Crescendo e Passando</p>
      <p>Todos os direitos reservados. 2018</p>
  </div>
  </body>
</html>