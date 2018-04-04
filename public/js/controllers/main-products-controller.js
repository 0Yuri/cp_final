(function () {
	'use strict';

	angular.module ('app')

	.controller ('ShowProductsController', ShowProductsController);

	function ShowProductsController ($http, $stateParams){
		var vm = this;
		vm.pegarProdutos = pegarProdutos;
		vm.changePage = changePage;
		vm.pegarNumeroPaginas = pegarNumeroPaginas;
		vm.filtrar = filtrar;
		vm.filtrarQualidade = filtrarQualidade;
		vm.filtro;
		vm.pagina;
		vm.paginas;

		_init();

		///////// Functions /////////

		function _init () {
			vm.pagina = 1;
			vm.quality = "wherever";
			pegarProdutos();
			vm.msg_error = "Procurando produtos...";
		}

		function filtrar(filter){
			vm.filter = filter;
			vm.pagina = 1;
			pegarProdutos();
			pegarNumeroPaginas();
		}

		function filtrarQualidade(quality){
			vm.quality = quality;
			vm.pagina = 1;
			pegarProdutos();
			pegarNumeroPaginas();
		}

		function changePage(index){
			vm.pagina += index;
			pegarProdutos();
		}

		function pegarProdutos(){
			var content = {
				page: vm.pagina,
				category: $stateParams.category_id,
				filter: vm.filter,
				quality: vm.quality
			};
			$http.post('system/public/product/getAll', content)
			.then(function(response){
				vm.show_error = response.data.success;
				if(response.data.success){
					vm.lista_produtos = response.data.object;
				}
				else{
					vm.msg_error = response.data.error;
				}
			});
		}

		function pegarNumeroPaginas(){
			var content = {
				category: $stateParams.category_id,
				filter: vm.filter,
				quality: vm.quality
			};
			$http.post('system/public/product/numberOfAll', content)
			.then(function(response){
				if(response.data.success){
					vm.paginas = response.data.object;
				}
				else{
					console.log(response.data.error);
				}
			});
		}



	}
})();
