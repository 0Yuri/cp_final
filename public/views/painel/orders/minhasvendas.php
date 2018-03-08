<div class="w3-container" style="padding: 0% 20% 5% 20%">
	<h2>Minhas vendas</h2>
	<div class="w3-row">
		<button class=" btn sales-btn" ng-click ="vm.setStatus()">Todas</button>
		<button class=" btn sales-btn" ng-click ="vm.setStatus('PROGRESS')">Vendas em aberto</button>
		<button class=" btn sales-btn" ng-click ="vm.setStatus('DONE')">Finalizadas</button>
		<button class=" btn sales-btn" ng-click ="vm.setStatus('CANCELLED')">Canceladas</button>
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
		<div class="w3-row w3-padding" ng-repeat="pedido in vm.vendas">
			<div class="w3-third text-left">
				<a ui-sref="root.panel.sale({id: pedido.unique_id})">{{pedido.order_id}}</a>
			</div>
			<div class="w3-third">
				{{pedido.status}}
			</div>
			<div class="w3-third">
				{{pedido.created_at}}
			</div>
		</div>
		<div class="w3-row w3-padding-16" ng-show="vm.paginas > 1">
			<button type="button" class="btn btn-default" ng-click="vm.setPage(-1)" ng-show="vm.pagina > 1">Anterior</button>
			<button type="button" class="btn btn-default" ng-click="vm.setPage(+1)" ng-show="vm.pagina <= vm.paginas">Próximo</button>
		</div>
	</div>
</div>
