<div class="w3-container">
	<div class="w3-row banner w3-hide-small">
		<img class="w3-image w3-round" style="width:100%" src="{{imgFolder}}site/banners/banner-produtos.png">
	</div>
	<div class="w3-row">
		<div class="w3-container panel panel-default w3-margin-top bg-color-3y">
			<form  ng-submit="vm.filter(vm.input)">
				<div class="w3-row form-group">
					<!-- Gênero Section -->
					<div class="w3-col l8">
						<h3>Filtrar por:</h3>
						<div class="w3-col l2">
							<label>
								<input type="radio" name="gender" hidden value="meninos" ng-click="vm.filtrar('meninos')">
								<img class="w3-image no-margin" src="{{imgFolder}}site/filters/boy-btn.png">
							</label>
						</div>
						<div class="w3-col l2">
							<label>
								<input type="radio" name="gender" hidden ng-click="vm.filtrar('meninas')">
								<img class="w3-image no-margin" src="{{imgFolder}}site/filters/girl-btn.png">
							</label>
						</div>
						<div class="w3-col l2">
							<label>
								<input type="radio" name="gender" hidden value="unisex" ng-click="vm.filtrar('unisex')">
								<img class="w3-image no-margin" src="{{imgFolder}}site/filters/unisex-btn.png">
							</label>
						</div>
						<div class="w3-col l2">
							<label>
								<input type="radio" name="gender" hidden ng-click="vm.filtrar('mamae')">
								<img class="w3-image no-margin" src="{{imgFolder}}site/filters/mother-btn.png">
							</label>
						</div>
						<div class="w3-col l2">
							<label>
								<input type="radio" name="gender" hidden ng-click="vm.filtrar('papai')">
								<img class="w3-image no-margin" src="{{imgFolder}}site/filters/father-btn.png">
							</label>
						</div>
					</div>
					<!-- Estado Section -->
					<div class="w3-col l4">
						<h3>Tempo de uso:</h3>
						<div class="w3-third no-margin">
							<label>
								<input type="radio" name="use-time" hidden ng-click="vm.filtrarQualidade('Novo')">
								<img class="img-responsive no-margin" src="{{imgFolder}}site/filters/nunca-usado-btn.png">
							</label>
						</div>
						<div class="w3-third no-margin">
							<label>
								<input type="radio" name="use-time" hidden ng-click="vm.filtrarQualidade('Bom estado')">
								<img class="img-responsive no-margin" src="{{imgFolder}}site/filters/pouco-usado-btn.png">
							</label>
						</div>
						<div class="w3-third">
							<label>
								<input type="radio" name="use-time" hidden ng-click="vm.filtrarQualidade('Com marcas de uso')">
								<img class="img-responsive no-margin" src="{{imgFolder}}site/filters/usado-btn.png">
							</label>
						</div>
					</div>
				</div>

				<!-- Filtros Section -->
				<div class="w3-row form-group" ng-show="false">
					<div class="w3-content">
						<div class="w3-row-padding">
							<div class="w3-col m2 s6">
								<select ng-model="vm.filter" class="form-control bg-color-2y flat-input" ng-change="vm.filtrar(vm.filter)">
									<option value="" disabled selected hidden>Preço</option>
									<option value="asce">Crescente</option>
									<option value="desc">Decrescente</option>
								</select>
							</div>
							<div class="w3-col m2">
								<button class="form-control btn btn-primary" type="submit" ng-click="vm.loadCategory()">Buscar!</button>
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>
	</div>

	<div class="w3-row">
		<!-- Barra lateral de filtros -->
		<div class="w3-quarter">
			<div class="side-filter w3-padding-16 w3-round">
				<div>
					<h4>Filtro de buscas</h4>
				</div>
				<div>
					<h4>Ordenar por:</h4>
					<select class="w3-border w3-round">
						<option>Menor preço</option>
						<option>Maior preço</option>
						<option>Ordem alfabética</option>
					</select>
				</div>
			</div>
			<br>
		</div>

		<!-- Listagem de produtos  -->
		<div class="w3-rest" ng-show="vm.show_error">
			<div class="w3-row">
				<div class="w3-third">
					<p></p>
				</div>
				<div class="w3-third">
					<p style="float: left;width: 250px;">Ficou mais fácil encontrar<br>produtos perto de você! Selecione<br>seu estado e <strong>economize no frete!</strong></p>
				</div>
			</div>
			<div class="w3-row w3-padding">
				<div ng-repeat="produto in vm.lista_produtos">
					<div class="w3-quarter w3-border" ui-sref="root.product(produto)">
						<img src="{{imgFolder}}site/discount/nuncausado.png" style="z-index=5;position:absolute;margin-top:-10px;margin-left:5px;width:50px;height:50px">
						<img class="" src="{{imgFolder}}site/products/{{produto.imagem}}" width="250px" height="250px">
						<div class="w3-container w3-center">
							<div class="w3-row w3-padding ">
								<b>{{produto.name}}</b> <br>
								Marca: {{produto.brand}} <br>
								Para {{produto.gender}}<br>
								<span class="bold" style="color:#87CEEB">R$ {{produto.price}}</span> <br>
								<span class="bold" style="color:#fec860">Em até 12x R$ {{produto.price / 12 | number: 2}}</span>
							</div>
						</div>
					</div>
					<!-- <div class="w3-col l3 m4 s6 w3-padding w3-left-align">
						<a ui-sref="root.product(produto)">
							<div class="w3-card-4 product-box">
								<div>
									<img ng-show="produto.quality == 'Novo'" src="{{imgFolder}}site/discount/nuncausado.png" style="z-index=5;position:absolute;margin-top:-10px;margin-left:5px;width:50px;height:50px">
									<img ng-show="produto.discount == 80" src="{{imgFolder}}site/discount/off80-2.png" style="position:absolute;margin-top:-15px;margin-left:220px;width:50px;height:60px;">
									<img ng-show="produto.discount == 70" src="{{imgFolder}}site/discount/off70-2.png" style="position:absolute;margin-top:-15px;margin-left:220px;width:50px;height:60px;">
									<img ng-show="produto.discount == 60" src="{{imgFolder}}site/discount/off60-2.png" style="position:absolute;margin-top:-15px;margin-left:220px;width:50px;height:60px;">
								</div>
								<div class="product-img-box">
									<img class="img-responsive no-margin" src="{{imgFolder}}site/products/{{produto.imagem}}" width="200px" height="200px">
								</div>
								<div class="w3-row-padding product-info-box">
										<b>{{produto.name}}</b> <br>
										Marca: {{produto.brand}} <br>
										Para {{produto.gender}}
								</div>
								<div class="w3-row-padding product-price-box">
									<span class="bold" style="color:#87CEEB">R$ {{produto.price}}</span> <br>
									<span class="bold" style="color:#fec860">Em até 12x R$ {{produto.price / 12 | number: 2}}</span>
								</div>
							</div>
						</a>
					</div> -->
				</div>
			</div>
			<div class="w3-row">
				<ul class="pager">
					<li>
						<a ng-click="vm.changePage(-1)" ng-show="vm.pagina > 1">Anterior</a>
					</li>
					<li>
						<a ng-click="vm.changePage(+1)" ng-show="vm.pagina < vm.paginas">Próxima</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="w3-rest" ng-show="!vm.show_error">
			<h3>{{vm.msg_error}}</h3>
		</div>
	</div>

</div>
