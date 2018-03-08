<div class="w3-row">
  <h3>Lojas</h3>
  <div class="w3-row">
    <form ng-submit="vm.pesquisarLoja(vm.info)">
      <input type="text" required ng-model="vm.info.name" class="w3-round w3-border">
      <button type="submit" class="w3-button w3-border w3-round">Pesquisar</button>
    </form>
  </div>
  <div class="w3-row w3-light-gray w3-padding-16">
    <div class="w3-quarter">
      Nome da loja:
    </div>
    <div class="w3-quarter">
      Dono da loja:
    </div>
    <div class="w3-quarter">
      Data de criação:
    </div>
    <div class="w3-quarter">
      Ações:
    </div>
  </div>
  <div class="w3-row" ng-repeat="store in vm.stores">
    <div class="w3-quarter">
      {{store.name}}
    </div>
    <div class="w3-quarter">
      {{store.first_name}} {{store.last_name}}
    </div>
    <div class="w3-quarter">
      {{store.created_at}}
    </div>
    <div class="w3-quarter">
      <button type="button" class="btn btn-default" ng-click="vm.visualizarLoja(store)"><span>Visualizar</span></button>
      <button type="button" class="btn btn-default" ng-click="vm.toggleLoja(store)">
        <span ng-show="store.status == 'desativado'">Ativar</span>
        <span ng-show="store.status == 'ativado'">Desativar</span>
      </button>
    </div>
  </div>
  <div class="w3-row" ng-show="vm.stores.length <= 0">
    Nenhuma loja foi encontrada.
  </div>
  <div class="w3-row" ng-show="vm.store">
    <h3>Informações da loja</h3>
    <div class="w3-row">
      <label>Nome da loja:</label>
      {{vm.store.name}}
    </div>
    <div class="w3-row">
      <label>Dono:</label>
      {{vm.store.first_name}} {{vm.store.last_name}}
    </div>
    <div class="w3-row">
      <label>Descrição:</label>
      {{vm.store.description}}
    </div>
    <div class="w3-row">
      <label>Telefone:</label>
      ({{vm.store.ddd}}) {{vm.store.phone}}
    </div>
    <div class="w3-row">
      <label>Número de vendas:</label>
      {{vm.store.sales}} vendas
    </div>
    <div class="w3-row">
      <label>Status:</label>
      <span ng-show="vm.store.status == 'ativado'">Ativado</span>
      <span ng-show="vm.store.status == 'desativado'">Desativado</span>
    </div>
    <div class="w3-row">
      <label>Criada em:</label>
      {{vm.store.created_at}}
    </div>
    <div class="w3-row">
      <div class="w3-half">
        <label>Logo da loja:</label>
        <img src="{{imgFolder}}stores/logo/{{vm.store.profile_image}}" width="250px" height="250px">
      </div>
      <div class="w3-half">
        <label>Banner da loja:</label>
        <img src="{{imgFolder}}stores/banner/{{vm.store.banner_image}}" width="250px" height="250px">
      </div>
    </div>
  </div>
</div>
