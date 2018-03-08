(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelSalesController', PanelSalesController);

	function PanelSalesController ($state, $http, userService){
		var vm = this;

		vm.pegarVendas = pegarVendas;
		vm.setPage = setPage;
		vm.setStatus = setStatus;

		vm.pagina;
		vm.paginas;

		_init();

		///////// Functions /////////

		function _init () {
			vm.pagina = 1;
			pegarVendas();
		}

		function setPage(valor){
			vm.pagina += valor;
			pegarVendas();
		}

		function setStatus(status){
			vm.status = status;
			vm.pagina = 1;
			pegarVendas();
		}

		function pegarVendas(){
			var type = {
				filter: vm.status,
				page: vm.pagina
			};
			$http.post('system/public/orders/mySales', type)
			.then(function(response){
				if(response.data.success){
					vm.vendas = response.data.object.vendas;
					vm.paginas = response.data.object.paginas;
				}
				else{
					console.log(response.data.error);
				}
			});
		}
 };
})();
