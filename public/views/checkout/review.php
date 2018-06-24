<div class="w3-row">

  <h3>Revise o seu pedido e escolha as formas de entrega</h3>

  <div class="w3-row" ng-repeat="pedido in vm.pedidos">
    <div class="w3-row sp-tl">
      Compras na {{pedido.nome_loja}}
    </div>
    <div class="w3-row">
      <div class="w3-third">
        Nome
      </div>
      <div class="w3-third">
        Quantidade
      </div>
      <div class="w3-third">
        Preço
      </div>
    </div>
    <div class="w3-row" ng-repeat="produto in pedido.produtos">
      <div class="w3-third">
        {{produto.nome}}
      </div>
      <div class="w3-third">
        {{produto.quantidade}}
      </div>
      <div class="w3-third">
        R$ {{produto.preco * produto.quantidade | number: 2}}
      </div>
    </div>
    <div class="w3-row w3-padding-16">
      <div class="w3-half">
        Você optou por receber este pedido no endereço:
        <div class="w3-border w3-round" style="margin:2%">
          <p>{{pedido.entrega.info.logradouro}} - {{pedido.entrega.info.numero}}</p>
          <p>{{pedido.entrega.info.localidade}} - {{pedido.entrega.info.uf}}</p>
          <p>CEP: {{pedido.entrega.info.cep}} - Bairro: {{pedido.entrega.info.bairro}}</p>
          <p>{{pedido.entrega.info.complemento}} {{pedido.entrega.info.referencia}}</p>
        </div>
      </div>
      <div class="w3-half w3-padding-16">
        <div class="w3-row" ng-init="vm.calcularEntrega(pedido, pedido.entrega)">
          <input type="radio" required ng-model="pedido.entrega.forma" class="w3-radio" ng-value="'sedex'"> SEDEX <p ng-show="pedido.entrega.valores.SEDEX"> R$ {{pedido.entrega.valores.SEDEX.valor | number: 2}} e prazo de entrega de {{pedido.entrega.valores.SEDEX.prazo}} dia(s).</p>
          <input type="radio" required ng-model="pedido.entrega.forma" class="w3-radio" ng-value="'pac'"> PAC <p ng-show="pedido.entrega.valores.PAC"> R$ {{pedido.entrega.valores.PAC.valor | number: 2}} e prazo de entrega de {{pedido.entrega.valores.PAC.prazo}} dia(s).</p>
        </div>
      </div>
    </div>
  </div>

  <div class="w3-row w3-padding-16">
    <button type="button" class="btn btn-default" ng-click="vm.confirmarPedidos(vm.pedidos)">Confirmar meu pedido</button>
  </div>

</div>
