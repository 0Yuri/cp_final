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
      <div class="w3-quarter" >
        <span ng-show="vm.pedido.tracking_code != null">
          {{vm.pedido.tracking_code}}
        </span>
        <span ng-show="vm.pedido.tracking_code == null">
          Não adicionado
        </span>
      </div>
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
          {{produto.price / 100 * produto.quantity | number: 2}}
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
            {{message.sent_at}}
            {{message.writer_id}}
          </div>
        </div>
      </div>
      <div class="panel-footer w3-white">
        <div class="w3-row">
          <div class="w3-col" style="width:50px">
            <i class="w3-xxlarge fa fa-pencil"></i>
          </div>
          <div class="w3-rest">
            <input type="text" class="w3-input w3-round w3-border" required ng-model="vm.newmessage.content" placeholder="Digite sua mensagem aqui.">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
