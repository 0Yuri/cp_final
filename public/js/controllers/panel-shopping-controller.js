(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelShoppingController', PanelShoppingController);

	function PanelShoppingController ($state, $http, userService){
		var vm = this;
		// Declaração de métodos
		vm.pegarCompras = pegarCompras;
		vm.setPagina = setPagina;
		vm.setStatus = setStatus;
		// Variables
		vm.msg_error = "Consultando pedidos, por favor aguarde...";
		vm.pedidos;
		vm.pagina;
		vm.status;

		_init();

		///////// Functions /////////
		function _init () {
			vm.pagina = 1;
			pegarCompras();
		}

		function setStatus(status){
			vm.status = status;
			vm.pagina = 1;
			pegarCompras();
		}

		function setPagina(valor){
			vm.pagina += valor;
			pegarCompras();
		}

		function pegarCompras(){
			var content = {
				filter: vm.status,
				page: vm.pagina
			};
			$http.post('system/public/orders/myOrders', content)
			.then(function(response){
				if(response.data.success){
					vm.pedidos = response.data.object;
				}else{
					vm.msg_error = response.data.error;
				}
			});
		}
 };
})();
