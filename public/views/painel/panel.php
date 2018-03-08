<style type="text/css">
	.b{
		border: 1px solid black;
	}
	.equal {
		display: flex;
		flex-wrap: wrap;
	}
	.equal > div[class*='col-'] {
		display: flex;
		flex-direction: column;
	}
	.nav-icon{
		font-size: 40px;
		color: #fec860;
	}
	.nav-itens button{
		background-color: transparent;
		border-style: none;
	}
	.nav-itens p{
		font-weight: bold !important;
		color: #ee9c49;
	}
</style>

<div class="w3-container" ng-init="vm.contentTitle='Cadastro'">
	<div class="w3-row">
		<div class="w3-third">
			<div class="profile" style="background-color:transparent">
				<div class="w3-third">
					<span></span>
				</div>
				<div class="w3-rest">
					<h3 style="text-transform:capitalize">Olá, {{vm.usuario.name}} {{vm.usuario.last_name}}</h3>
				</div>
			</div>
		</div>
		<div class="w3-twothird">
			<div ng-if="!user.store" class="w3-row nav-itens">
				<button class="" ng-click="vm.loadContent('dashboard')">
					<i class="fa fa-bar-chart nav-icon" aria-hidden="true"></i> <p>PAINEL</p>
				</button>
				<button class="" ng-click="vm.loadContent('favorites')">
					<i class="fa fa-heart nav-icon" aria-hidden="true"></i> <p>FAVORITOS</p>
				</button>
				<button class="" ng-click="vm.loadContent('store')">
					<i class="fa fa-home nav-icon" aria-hidden="true"></i> <p>LOJINHA</p>
				</button>
				<button class="" ng-click="vm.loadContent('shopping')">
					<i class="fa fa-shopping-bag nav-icon" aria-hidden="true"></i> <p>COMPRAS</p>
				</button>
				<button ng-click="vm.loadContent('questions')">
					<i class="fa fa-comments-o nav-icon" aria-hidden="true"></i> <p>PERGUNTAS</p>
				</button>
				<button class="" ng-click="vm.loadContent('sales')">
					<i class="fa fa-book nav-icon" aria-hidden="true"></i> <p>VENDAS</p>
				</button>
				<button class="" ng-click="vm.loadContent('messagens')">
					<i class="fa fa-envelope-open nav-icon" aria-hidden="true"></i> <p>MENSAGENS</p>
				</button>
				<button class="" ng-click="vm.loadContent('withdraw')">
					<i class="fa fa-money nav-icon" aria-hidden="true"></i> <p>FINANÇAS</p>
				</button>
				<button class="" ng-click="vm.loadContent('myaccount')">
					<i class="fa fa-user nav-icon" aria-hidden="true"></i> <p>MINHA CONTA</p>
				</button>
			</div>
		</div>
	</div>
	<div class="w3-row">
		<div class="w3-row w3-padding-16">
			<ui-view></ui-view>
		</div>
	</div>
</div>
