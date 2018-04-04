(function () {
	'use strict';

	angular.module ('app')


	.controller ('PanelViewStoreController', PanelViewStoreController);


	function PanelViewStoreController ($state, $http, $scope){
		var vm = this;

		vm.pegarProdutos = pegarProdutos;
		vm.toggleProduct = toggleProduct;

		vm.getLoja = getLoja;
		vm.mudarStatus = mudarStatus;
		vm.statusStore = statusStore;
		vm.setPage = setPage;

		vm.store_status = false;
		vm.msg = "Consultando os produtos da loja...";
		vm.store_active;
		vm.pagina;
		vm.paginas;

		_init();
		///////// Functions /////////

		function _init () {
			vm.pagina = 0;
			vm.paginas = 1;
			getLoja();
		}

		function getLoja(){
			$http.get('system/public/store/loggedStore')
			.then(function(response){
				vm.store_status = response.data.success;
				if(response.data.success){
					vm.minhaloja = response.data.object;
					pegarProdutos();
				}
				else{
				}
			});
			statusStore();
		}

		function mudarStatus(){
			$http.get('system/public/store/toggleStore')
			.then(function(response){
				if(response.data.success){
					$state.go('root.panel.dashboard');
				}else{
					alert(response.data.error);
				}
			});
		}

		function statusStore(){
			$http.get('system/public/store/statusStore')
			.then(function(response){
				vm.store_active = response.data.success;
			});
		}

		function toggleProduct(field){
			$http.post('system/public/product/toggleStatus', field)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			})
		}

		function setPage(valor){
			vm.pagina += valor;
			pegarProdutos();
		}

		function pegarProdutos(){
			var content = {
				page: vm.pagina
			};
			$http.post('system/public/product/loggedProducts', content)
			.then(function(response){
				if(response.data.success){
					vm.produtos_lista = response.data.object.produtos;
					vm.paginas = response.data.object.paginas;
				}else{
					vm.msg = "Esta loja não possui nenhum produto.";
				}
			});
		}
	}
})();
