<div class="w3-row">
  <h3>Hora de escolher as formas de entrega</h3>
  <div class="w3-row w3-padding-16">
    {{vm.error}}
  </div>
  <!-- {{vm.pedidos}} -->
  <div class="w3-row">
    <form ng-submit="vm.definirEntrega(vm.pedidos)">
      <div class="w3-row" ng-repeat="pedido in vm.pedidos">
          <div class="w3-row w3-light-gray">
            Pedido na <b>{{pedido.nome_loja}}</b>
          </div>
          <div class="w3-row">
            <div class="w3-quarter">
              Prévia
            </div>
            <div class="w3-quarter">
              Produto
            </div>
            <div class="w3-quarter">
              Quantidade
            </div>
            <div class="w3-quarter">
              Preço
            </div>
          </div>
          <div class="w3-row w3-padding-16" ng-repeat="produto in pedido.produtos" ng-hide="key == 'entrega' || key == 'envio' || key == 'cep'">
            <div class="w3-quarter">
              <img class="w3-round" src="{{imgFolder}}site/products/{{produto.imagem}}" alt="previewproduto" width="60px" height="60px">
            </div>
            <div class="w3-quarter">
              {{produto.nome}}
            </div>
            <div class="w3-quarter">
              {{produto.quantidade}}
            </div>
            <div class="w3-quarter">
              R$ {{produto.preco * produto.quantidade | number: 2}}
            </div>
          </div>
          <div class="w3-row w3-padding-16">
            <h4>Forma de entrega</h4>
            <div class="w3-row">
            </div>
            <div class="w3-row">
              <label>
                Meu endereço
              </label>
              <input type="radio" class="w3-radio" ng-required="pedido.entrega.type == null" ng-model="pedido.entrega.type" value="user">
              <label>
                Outro endereço
              </label>
              <input type="radio" class="w3-radio" ng-required="pedido.entrega.type == null" ng-model="pedido.entrega.type" value="other">
            </div>
            <!-- Formulário de endereço alternativo -->
            <div class="w3-row w3-padding-16" ng-show="pedido.entrega.type == 'other'">
              <!-- CEP e Rua -->
              <div class="w3-row">
                <div class="w3-third" style="padding: 0 2%">
                  <label>
                    CEP:
                  </label>
                  <br>
                  <input type="text" mask="99999-999" class="w3-input w3-round w3-border" ng-required="pedido.entrega.type == 'other'" ng-model="pedido.entrega.info.cep" ng-change="vm.textChanged(pedido.entrega)" placeholder="99999-999">
                </div>
                <div class="w3-rest" style="padding: 0 2%">
                  <label>
                    Logradouro:
                  </label>
                  <br>
                  <input type="text" class="w3-input w3-round w3-border"  ng-required="pedido.entrega.type == 'other'" ng-model="pedido.entrega.info.logradouro" placeholder="Digite a rua aqui">
                </div>
              </div>

              <!-- Estado, cidade e número -->
              <div class="w3-row">
                <div class="w3-quarter" style="padding: 0 2%">
                  <label>Estado:</label><br>
                  <input type="text" class="w3-input w3-round w3-border" ng-required="pedido.entrega.type == 'other'" mask="AA" ng-model="pedido.entrega.info.uf" placeholder="EX">
                </div>
                <div class="w3-quarter" style="padding: 0 2%">
                  <label>Cidade:</label><br>
                  <input type="text" class="w3-input w3-round w3-border" ng-required="pedido.entrega.type == 'other'" ng-model="pedido.entrega.info.localidade" placeholder="Digite a cidade de destino">
                </div>
                <div class="w3-quarter" style="padding: 0 2%">
                  <label>Bairro:</label>
                  <input type="text" class="w3-input w3-round w3-border" ng-required="pedido.entrega.type == 'other'" ng-model="pedido.entrega.info.bairro" placeholder="Digite o bairro">
                </div>
                <div class="w3-quarter" style="padding: 0 2%">
                  <label>Número:</label>
                  <input type="text" class="w3-input w3-round w3-border" ng-required="pedido.entrega.type == 'other'" ng-model="pedido.entrega.info.numero" placeholder="Digite o número">
                </div>
              </div>

              <!-- Complemento -->
              <div class="w3-row" style="padding: 0 2%">
                <label>Complemento:</label>
                <input type="text" class="w3-input w3-round w3-border" ng-model="pedido.entrega.info.complemento" placeholder="Digite o complemento">
              </div>
            </div>

          </div>
      </div>
      <div class="w3-row w3-padding">
        <button class="btn btn-default" type="submit">Definir entregas</button>
      </div>
    </form>
  </div>
</div>
