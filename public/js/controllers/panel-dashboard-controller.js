(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelDashboardController', PanelDashboardController);

	function PanelDashboardController ($state, $http, userService) {
		var vm = this;

		userService.onlyUsers();
		vm.valor = 12;
		vm.freeze = freeze;
		vm.gerenciarProdutos = gerenciarProdutos;
		vm.checkLoja = checkLoja;
		vm.store_active;
		vm.getSaldo = getSaldo;

		_init();

		///////// Functions /////////

		function _init () {
			checkLoja();
			getSaldo();
		};

		function checkLoja(){
			$http.get('system/public/store/statusStore')
			.then(function(response){
				vm.store_active = response.data.success;
			});
		}

		function getSaldo(){
			$http.get('system/public/moip/balance')
			.then(function(response){
				if(response.data.success){
					vm.saldo = response.data.object;
				}
				else{
					vm.saldo = "Error";
				}
			});
		}

		function freeze (){
		};

		function gerenciarProdutos () {
		};
	};
})();
