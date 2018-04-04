<div class="w3-row">
  <h3>Resultados da pesquisa</h3>

  <!-- Products -->
  <div class="w3-row">
    <h4>Produtos</h4>
    <div class="w3-row sp-tl">
      <div class="w3-row">
        <div class="w3-third">
          Nome
        </div>
        <div class="w3-third">
          Gênero
        </div>
        <div class="w3-third">
          Desconto
        </div>
      </div>
    </div>
    <div class="w3-row" ng-show="vm.products.success" style="padding-left:2%;padding-right:2%">
      <div class="w3-row" ng-repeat="product in vm.products.results">
        <div class="w3-third">
          <a ui-sref="root.product(product)">{{product.name}}</a>
        </div>
        <div class="w3-third">
          {{product.gender}}
        </div>
        <div class="w3-third">
          {{product.discount}}
        </div>
      </div>
    </div>
    <div class="w3-row" ng-if="!vm.products.success">
      <span>{{vm.products_error}}</span>
    </div>
  </div>

  <!-- Stores -->
  <div class="w3-row">
    <h4>Lojas</h4>
    <div class="w3-row sp-tl">
      <div class="w3-rest">
        Nome
      </div>
    </div>
    <div class="w3-row" ng-repeat="store in vm.stores.results">
      <a ui-sref="root.store(store)">{{store.name}}</a>
    </div>
    <div class="w3-row" ng-if="!vm.stores.success">
      <span>{{vm.stores_error}}</span>
    </div>
  </div>
</div>
