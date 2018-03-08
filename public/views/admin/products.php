<div class="w3-row">
  <h3>Produtos</h3>
  <div class="w3-row w3-padding-16">
    <form ng-submit="vm.pesquisarProduto(vm.info)">
      <input type="text" class="w3-round w3-border" required ng-model="vm.info.name">
      <button type="submit" class="w3-button w3-border w3-round">Pesquisar</button>
    </form>
  </div>
</div>
