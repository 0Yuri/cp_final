<div class="w3-content text-center" style="padding: 0 5% 0 5%">
  <div class="panel panel-default w3-padding-16">
    <!-- Info do pedido -->
    <div class="w3-row">
      <h4>Informações do pedido</h4>
    </div>
    <div class="w3-row">
      <div class="w3-quarter">
        Data do pedido:
      </div>
      <div class="w3-quarter">
         {{vm.pedido.created_at}}
      </div>
      <div class="w3-quarter">
        Data do pagamento:
      </div>
      <div class="w3-quarter">
        {{vm.pedido.payed_at}}
      </div>
    </div>
    <div class="w3-row">
      <div class="w3-quarter">
        Forma de pagamento:
      </div>
      <div class="w3-rest" style="text-transform:capitalize">
        <img style="margin-bottom:0px" ng-show="vm.pedido.payment_method == 'boleto'" src="{{imgFolder}}site/checkout/checkout-boleto.gif" title="Boleto bancário" width="50px" height="50px">
        <img style="margin-bottom:0px" ng-show="vm.pedido.payment_method == 'card'"   src="{{imgFolder}}site/checkout/checkout-creditcard.svg" title="Cartão de crédito" width="50px" height="50px">
        <img style="margin-bottom:0px" ng-show="vm.pedido.payment_method == 'debit'"  src="{{imgFolder}}site/checkout/checkout-debit.svg" title="Débito online" width="50px" height="50px">
        <br>
      </div>
    </div>
    <div class="w3-row w3-padding-16">
      <div class="w3-quarter">
        Identificador do pedido:
      </div>
      <div class="w3-rest">
        {{vm.pedido.order_id}}
      </div>
    </div>
    <div class="w3-row">
      <div class="w3-quarter">
        Status do pedido:
      </div>
      <div class="w3-rest">
        <span ng-show="vm.pedido.status == 'PAID'">Pagamento realizado</span>
        <span ng-show="vm.pedido.status == 'WAITING'">Aguardando pagamento</span>
        <span ng-show="vm.pedido.status == 'CREATED'">Aguardando pagamento</span>
        <span ng-show="vm.pedido.status == 'CANCELLED'">Cancelado</span>
      </div>
    </div>
    <!-- Info de entrega -->
    <div class="w3-row">
      <h4>Informações de entrega</h4>
    </div>
    <div class="w3-row">
      <div class="w3-quarter">
        <i class="fa fa-truck"></i> Forma de envio:
      </div>
      <div class="w3-quarter" style="text-transform:capitalize">
        {{vm.pedido.shipping_method}}
      </div>
      <div class="w3-quarter">
        Cód. de rastreio
      </div>
      <div class="w3-quarter">
        <span ng-show="vm.pedido.tracking_code != null">
          <a target="_blank" href="http://www.websro.com.br/correios.php?P_COD_UNI={{vm.pedido.tracking_code}}">{{vm.pedido.tracking_code}}</a>
        </span>
        <span ng-show="vm.pedido.tracking_code == null">
          <button type="button" class="btn btn-default w3-round-xlarge" onclick="myFunction('rastreio')">Adicionar Rastreio</button>
        </span>
      </div>
    </div>
    <div class="w3-row w3-hide" id="rastreio">
        <h4>Insira o código de rastreio</h4>
        <form ng-submit="vm.cadastrarRastreio(vm.pedido)">
          <input type="text" class="w3-border w3-round" required ng-model="vm.pedido.tracking_code">
          <button type="submit" class="btn btn-default">Cadastrar</button>
        </form>
    </div>
    <br>
    <!-- Produtos -->
    <div class="w3-row w3-round">
      <div class="w3-row">
        <div class="w3-quarter">
          Produto
        </div>
        <div class="w3-quarter">
          Preço
        </div>
        <div class="w3-quarter">
          Quantidade
        </div>
        <div class="w3-quarter">
          Total:
        </div>
      </div>
      <div class="w3-row" ng-repeat="produto in vm.pedido.products">
        <div class="w3-quarter">
          <a ui-sref="root.product({name:produto.name})">{{produto.product}}</a>
        </div>
        <div class="w3-quarter">
          R$ {{produto.price / 100 | number: 2}}
        </div>
        <div class="w3-quarter">
          {{produto.quantity}}
        </div>
        <div class="w3-quarter">
          R$ {{produto.price / 100 * produto.quantity | number: 2}}
        </div>
      </div>
    </div>

    <br>
    <!-- Resumo dos Valores  -->
    <div class="w3-row">
      <div class="w3-row">
        <h4>Resumo dos valores</h4>
      </div>
      <div class="w3-row">
        <div class="w3-third">
          Subtotal
        </div>
        <div class="w3-third">
          <i class="fa fa-truck"></i> Frete
        </div>
        <div class="w3-third">
          Total
        </div>
      </div>
      <div class="w3-row">
        <div class="w3-third">
          R$ {{vm.pedido.price | number: 2}}
        </div>
        <div class="w3-third">
          R$ {{vm.pedido.frete| number: 2}}
        </div>
        <div class="w3-third">
          R$ {{vm.pedido.price + vm.pedido.frete | number: 2}}
        </div>
      </div>
    </div>

    <div class="w3-row w3-padding-16">
      <div>
        <div style="padding: 0 20%" ng-show="!vm.avaliou">
          Já entregou o produto? Avalie o comprador!
          <form ng-submit="vm.avaliarComprador(vm.info)">
            <div class="w3-row">
              <label>Como foi sua experiência?</label>
              <select class="w3-select w3-round w3-border" required ng-model="vm.info.rate">
                <option value="" selected disabled>Selecione uma opção</option>
                <option value="Excelente">Excelente</option>
                <option value="Muito bom">Muito bom</option>
                <option value="Bom">Bom</option>
                <option value="Normal">Normal</option>
                <option value="Ruim">Ruim</option>
              </select>
            </div>
            <button type="submit" class="btn btn-default">Avaliar sua venda</button>
          </form>
        </div>
        <div ng-show="vm.avaliou">
          Você avaliou o comprador como {{vm.avaliacao.rate}}.
        </div>
      </div>
      <div class="">
        <div ng-show="!vm.fuiavaliado">
          Você ainda não foi avaliado.
        </div>
        <div ng-show="vm.fuiavaliado">
          Você foi avaliado como {{vm.minhaavaliacao.rate}}.
        </div>
      </div>
    </div>
  </div>

  <br>
  <!-- Chat section -->
  <div class="w3-row" style="padding: 0% 10% 5% 10%;">
    <div class="panel panel-default">
      <div class="panel-heading">
        Chat
      </div>
      <div class="panel-body" style="background-color:lightgoldenrodyellow;max-height:300px;overflow-y:scroll">
        <div class="w3-center panel panel-default" ng-repeat="message in vm.messages" style="height:auto;overflow-wrap:break-word;">
          <div class="panel-body">
            {{message.content}}
          </div>
          <div class="panel-footer">
            Enviada às {{message.sent_at}} por
            {{message.name}}
          </div>
        </div>
      </div>
      <div class="panel-footer w3-white">
        <div class="w3-row">
          <form ng-submit="vm.enviarMensagem(vm.newmessage)">
            <div class="w3-col" style="width:50px">
              <button type="submit" class="btn btn-default"><i class="w3-xxlarge fa fa-pencil"></i></button>
            </div>
            <div class="w3-rest">
              <input type="text" class="w3-input w3-round w3-border" required ng-model="vm.newmessage.content" placeholder="Digite sua mensagem aqui.">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
