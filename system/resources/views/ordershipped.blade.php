<html>
    <style>
        .row{width:100%;float:left;}
        .capitalizar{text-transform:capitalize;}
        table{font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}
        td, th {border: 1px solid #dddddd;text-align: left;padding:8px}
        tr:nth-child(even) {background-color: #dddddd;}
    </style>
    <body>
        <div class="row">
        <img src="http://www.crescendoepassando.com.br/public/img/site/header/logo.png" alt="teste" width="auto" height="250px">
        </div>        
        <div class="row">
            <div class="row">
                <h4 class="capitalizar">olá, {{$buyer_name}}</h4>  
            </div>
            <div class="row">
                <p>O conteúdo do seu pedido <a target="_blank" href="http://localhost/compra/{{$order_id}}">{{$order_id}}</a> foi enviado hoje pelo vendedor,
                 o código de rastreamento é <a href="http://www.websro.com.br/correios.php?P_COD_UNI={{$tracking_code}}">{{$tracking_code}}</a>.</p>
                <p>Para rastrear o seu pedido recomendamos o uso dos sistema dos Correios.</p>
                <p><a target="_blank" href="http://www2.correios.com.br/sistemas/rastreamento/">Clique aqui para visitar o sistema dos correios.</a></p>
            </div>
        </div>
    </body>
</html>