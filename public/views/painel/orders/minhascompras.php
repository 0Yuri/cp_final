<div class="w3-container" style="padding: 0% 20% 5% 20%">
  <h2>Minhas compras</h2>
	<div class="w3-row">
		<button class="btn sales-btn" ng-click="vm.setStatus()">Todas</button>
		<button class="btn sales-btn" ng-click="vm.setStatus('PROGRESS')">Em andamento</button>
		<button class="btn sales-btn" ng-click="vm.setStatus('CANCELLED')">Canceladas</button>
		<button class="btn sales-btn" ng-click="vm.setStatus('DONE')">Finalizadas</button>
	</div>
	<div class="w3-round-xlarge" style="background-color:lightgoldenrodyellow;margin:3%;border-style:solid">
		<div class="w3-row w3-padding" style="border-bottom:solid">
			<div class="w3-third text-left">
				<b>Identificador</b>
			</div>
			<div class="w3-third">
				<b>Status</b>
			</div>
			<div class="w3-third">
				<b>Data</b>
			</div>
		</div>
		<div class="w3-row w3-padding" ng-repeat="pedido in vm.pedidos.compras">
			<div class="w3-third text-left">
				<a ui-sref="root.panel.buy({id: pedido.unique_id})">{{pedido.unique_id}}</a>
			</div>
			<div class="w3-third">
				{{pedido.status}}
			</div>
			<div class="w3-third">
				{{pedido.created_at}}
			</div>
		</div>
	</div>
  <div class="w3-row w3-padding-16">
    <button type="button" class="btn btn-default w3-round" ng-show="vm.pagina > 1" name="button" ng-click="vm.setPagina(-1);">Anterior</button>
    <button type="button" class="btn btn-default w3-round" ng-show="vm.pagina < vm.pedidos.paginas" name="button" ng-click="vm.setPagina(+1);">Próximo</button>
    <br>
    {{vm.pagina}} de {{vm.pedidos.paginas}}
  </div>
</div>
