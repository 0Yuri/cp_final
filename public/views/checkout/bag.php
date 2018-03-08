<div class="w3-row w3-padding-32" style="" ng-show="vm.carrinho.length == 0">
  <i class="fa fa-frown-o" style="font-size:55px"></i><h3> Nenhum pedido foi realizado, sua sacolinha se encontra vazia!</h3>
</div>

<div class="w3-row" ng-show="vm.carrinho.length != 0">
  <h3 class="w3-center w3-padding-large">Minha sacolinha</h3>

  <div class="w3-row">
    <div class="w3-row">
      <button type="button" class="btn btn-warning dash-btn" ui-sref="root.showProducts({category_id:0})">Continuar comprando</button>
      <button type="button" class="btn btn-warning dash-btn" ng-click="vm.setOrder()">Prosseguir para Pagamento</button>
      <button type="button" class="btn btn-warning dash-btn" ng-click="vm.limparCarrinho()">Limpar Carrinho</button>
    </div>
  </div>

    <div class="w3-row text-center" ng-repeat="item in vm.carrinho" ng-hide="item.length == 0">
      <form ng-submit="vm.calcularFrete(item)">
        <!-- Carrinho header -->
        <div class="w3-row sp-tl">
          <div class="w3-row">VENDEDOR {{item.nome_loja}}</div>
          <div class="w3-quarter">PRODUTO</div>
          <div class="w3-quarter">QUANTIDADE:</div>
          <div class="w3-quarter">VALOR DO PRODUTO</div>
          <div class="w3-quarter">AÇÕES</div>
        </div>
        <!-- Shopping list -->
        <div class="w3-row w3-padding-large" ng-repeat="(key,objeto) in item.produtos">
          <div class="w3-quarter">
            <img src="{{imgFolder}}site/products/{{objeto.imagem}}" class="w3-image w3-round w3-left" style="max-width:60px;max-height:60px">
            {{objeto.nome}}
          </div>
          <div class="w3-quarter">
            <button type="button" class="w3-round" ng-click="vm.quantidade(item.id_loja, key, -1)"><i class="fa fa-arrow-left"></i></button>
            {{objeto.quantidade}}
            <button type="button" class="w3-round" ng-click="vm.quantidade(item.id_loja, key, +1)"><i class="fa fa-arrow-right" ></i></button>
          </div>
          <div class="w3-quarter">
            R$ {{objeto.preco * objeto.quantidade| number: 2}}
          </div>
          <div class="w3-quarter w3-right">
            <button type="button" class="btn w3-round-xxlarge btn-default" ng-click="vm.remover(item.id_loja, key)">Remover do carrinho</button>
          </div>
        </div>
        <!-- Frete Section -->
        <div class="w3-row" style="border-top:solid;border-color:#fdbd0a">
          <div class="w3-row sp-dl">
            <div class="w3-half">
              <h6>Digite o cep para calcularmos o valor do frete</h6>
            </div>
            <div class="w3-half">
              <input type="text" class="w3-border w3-round" placeholder="99999-999" ng-model="item.cep" mask="99999-999" maxlength="9">
              <button type="submit" class="btn btn-primary">Calcular frete</button>
            </div>
            <div class="w3-half text-left">
              <div class="w3-row">
                <input type="radio" class="w3-radio" ng-model="item.entrega" ng-value="'sedex'"> SEDEX
                <span ng-show="item.envio.SEDEX">, R$ {{item.envio.SEDEX.valor | number:2 }}, Prazo de entrega: {{item.envio.SEDEX.prazo}} dias utéis.</span>
              </div>
              <div class="w3-row">
                <input type="radio" class="w3-radio" ng-model="item.entrega" ng-value="'pac'"> PAC
                <span ng-show="item.envio.PAC">, R$ {{item.envio.PAC.valor | number:2 }}, Prazo de entrega: {{item.envio.PAC.prazo}} dias utéis.</span>
              </div>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>
