<div class="w3-third w3-padding">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="well"><h4>PRODUTOS</h4></div>
			<table class="dash-table">
				<tr>
					<td>
						<h5>Vendidos</h5>
					</td>
					<td>
						<span ng-bind="vm.valor"></span>
					</td>
				</tr>
				<tr>
					<td>
						<h5>Reservados</h5>
					</td>
					<td>
						<span ng-bind="vm.valor"></span>
					</td>
				</tr>
				<tr>
					<td>
						<h5>Publicados</h5>
					</td>
					<td>
						<span ng-bind="vm.valor"></span>
					</td>
				</tr>
				<tr>
					<td>
						<h5>Não Publicados</h5>
					</td>
					<td>
						<span ng-bind="vm.valor"></span>
					</td>
				</tr>
			</table>
			<button ui-sref="root.panel.store" class="btn btn-warning dash-btn">Gerenciar seus produtos</button>
		</div>

	</div>
</div>

<div class="w3-third w3-padding">
	<div class="w3-row">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="well">
					<h4>AVALIAÇÕES</h4>
				</div>
				<table class="dash-table">
					<tr ng-repeat="avaliacao in [1,2,3]">
						<td>
							<h5>Av. {{avaliacao}}</h5>
						</td>
					</tr>
				</table>
				<button class="btn btn-warning dash-btn">Gerenciar avaliações</button>
			</div>
		</div>
	</div>
</div>

<div class="w3-third w3-padding">
	<div class="w3-row">
		<div class="panel panel-default">
			<div class="panel-body w3-padding-16">
				<div class="w3-row" class="">
					<a href="" ui-sref="root.panel.store" class="">
						<span ng-show="vm.store_active">Loja ativada</span>
						<span ng-show="!vm.store_active">Loja desativada</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="w3-row">
		<div class="panel panel-default w3-padding">
			Saldo Disponível R$ {{vm.saldo.disponivel | number: 2}}
			<br>
			Lançamentos Futuros R$ {{vm.saldo.futuro | number: 2}}
			<br>
			Saldo indisponível R$ {{vm.saldo.indisponivel | number: 2}}
			<br><br>
			<button type="button" class="btn btn-warning dash-btn" ui-sref="root.panel.withdraw">Sacar Dinheiro</button>
		</div>
	</div>
</div>
