(function () {
	'use strict';

	angular.module ('app')


	.controller ('PanelViewStoreController', PanelViewStoreController);


	function PanelViewStoreController ($state, $http, $scope){
		var vm = this;

		vm.pegarProdutos = pegarProdutos;
		vm.toggleProduct = toggleProduct;
		vm.criarContaMoip = criarContaMoip;
		
		vm.getLoja = getLoja;
		vm.mudarStatus = mudarStatus;
		vm.statusStore = statusStore;
		vm.setPage = setPage;
		
		vm.exibirConteudo;
		vm.store_status = false;
		vm.msg = "Consultando os produtos da loja...";
		vm.store_active;
		vm.pagina;
		vm.paginas;
		vm.link_moip;

		_init();
		///////// Functions /////////

		function _init () {
			vm.pagina = 0;
			vm.paginas = 1;
			getLoja();
			verificaMoip();
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

		function criarContaMoip(){
			$http.get('system/public/moip/novaconta')
			.then(function(response){
				if(response.data.success){

				}
				else{
					console.log(response.data.error);
				}
			})
		}

		function verificaMoip(){
			$http.get('system/public/stores/verificaMoip')
			.then(function(response){
				vm.exibirConteudo = response.data.success;
				if(!response.data.success){
					pegarLinkMoip();
				}
			});
		}

		function pegarLinkMoip(){
			$http.get('system/public/moip/connect')
			.then(function(response){
				if(response.data.success){
					vm.link_moip = response.data.object;
				}
			});
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
