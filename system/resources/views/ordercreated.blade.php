<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
    <img src="http://www.crescendoepassando.com.br/public/img/site/header/logo.png" alt="teste" width="auto" height="250px">
    <br>

    <p><h3>O seu pedido {{$order_id}} foi criado com sucesso.</h3></p>
    
    <table>
  <tr>
    <th>Nome do produto</th>
    <th>Quantidade</th>
    <th>Preço</th>
  </tr>
  @foreach ($order['produtos'] as $produto)
  <tr>
    <td>{{$produto['nome']}}</td>
    <td>{{$produto['quantidade']}}</td>
    <td>R$ {{$produto['preco']}}</td>
  </tr>
  @endforeach
</table>
</body>
</html>