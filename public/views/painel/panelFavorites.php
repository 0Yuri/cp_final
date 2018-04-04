<div class="w3-row w3-padding-16">
	<div class="w3-row">
		<h3 class="text-left w3-padding">Meus favoritos</h3>
	</div>
	<div class="w3-row w3-padding-16 topRepeater">
		<div class="w3-third">
			Nome
		</div>
		<div class="w3-third w3-right">
			Ações
		</div>
	</div>
	<div ng-show="vm.favorites">
		<div class="w3-row repeater" ng-repeat="favorito in vm.favorites">
			<div class="w3-third">
				<a target="_blank" ui-sref="root.product(favorito)">{{favorito.name}}</a>
			</div>
			<div class="w3-third w3-right">
				<a ng-click="vm.removerFavorito(favorito)" data-toggle="tooltip" data-placement="right" title="Excluir um favorito ficou bem fácil!">Remover</a>
			</div>
		</div>
		<div class="w3-row w3-padding-16">
			<button type="button" class="btn btn-default" ng-click="vm.setPage(-1)" ng-show="vm.pagina > 0">Anterior</button>
			<button type="button" class="btn btn-default" ng-click="vm.setPage(+1)" ng-show="vm.pagina < vm.paginas - 1">Próximo</button>
		</div>
	</div>
	<div class="w3-padding-16" ng-show="!vm.favorites">
		<h3>{{vm.favorites_error}}</h3>
	</div>

</div>
