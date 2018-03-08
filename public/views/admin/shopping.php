<div class="w3-row">
  <h3>Compras</h3>
  <div class="w3-row w3-padding-16 w3-light-gray" ng-init="vm.estatisticas()">
    <div class="w3-row">
      Total de compras: {{vm.stats.total}}
    </div>
    <div class="w3-row">
      Compras com boleto bancário: {{vm.stats.boleto}}
    </div>
    <div class="w3-row">
      Compras com cartão de crédito: {{vm.stats.cartao}}
    </div>
    <div class="w3-row">
      Pedidos utilizando SEDEX: {{vm.stats.sedex}}
    </div>
    <div class="w3-row">
      Pedidos utilizando PAC: {{vm.stats.pac}}
    </div>
  </div>
</div>
