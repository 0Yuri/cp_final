<div class="container-fluid">
	<div class="container-fluid min-margin padding-20">
		<div class="row">
			<div class="col-md-8">
				<div>
					Encontramos 00 resultados para sua busca por <span ng-bind="vm.search"></span>.
				</div>
			</div>
			<div class="col-md-4">
				<form class="form-inline">
					<div class="form-group">
						<label for="displayPriority">Exibir por:</label>
						<select id="displayPriority" name="displayPriority" class="form-control bg-color-2y flat-input">
							<option value="" disabled selected hidden>Choose</option>
							<option value="1">Teste</option>
							<option value="2">Teste 2</option>
							<option value="3">Teste 3</option>
						</select>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 hidden-xs">
			<div class="border">FILTROS</div>
		</div>
		<div class="col-md-9">
			<div class="row">
				<div class="container-fluid">
					<div class="panel panel-default">
						FILTRO POR ESTADO
					</div>
				</div>
			</div>
			<div class="row">
				<div ng-repeat="i in [1,2,3,4,5,6,7,8,9]">
					<div class="col-md-4 col-xs-6 min-margin w3-left-align">
						<a href="#">
							<div class="w3-card-4 product-box">
								<div class="product-img-box">
									<img class="img-responsive no-margin" src="{{imgFolder}}site/a.jpg" width="auto">
								</div>
								<div class="w3-row-padding product-info-box">
										<b>Nome do Produto Lorem Ipsum Dolor Sit Amet</b> <br>
										Marca: Não informado <br>
										(0 anos)
								</div>
								<div class="w3-row-padding product-price-box">
									<span class="bold" style="color:#87CEEB">R$ 00,00</span> <br>
									<span class="bold" style="color:#fec860">12x R$ 00,00</span>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
