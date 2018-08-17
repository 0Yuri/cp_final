(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelDashboardController', PanelDashboardController);

	function PanelDashboardController ($state, $http, userService) {
		var vm = this;
		vm.store_active;
		vm.status_conta;
		vm.link_botao;
		
		
		vm.checkLoja = checkLoja;
		vm.getBalance = getBalance;
		vm.getEvaluations = getEvaluations;

		vm.getSolds = getSolds;
		vm.getActiveProducts = getActiveProducts;
		vm.getNonActiveProducts = getNonActiveProducts;		

		_init();

		///////// Functions /////////

		function _init () {
			checkLoja();
			getBalance();
			getSolds();
			getActiveProducts();
			getNonActiveProducts();
			getEvaluations();
		};

		function checkLoja(){
			$http.get('system/public/store/statusStore')
			.then(function(response){
				vm.store_active = response.data.success;
			});
		}

		function getBalance(){
			$http.get('system/public/moip/balance')
			.then(function(response){
				vm.saldo = response.data.object;
				vm.status_conta = response.data.success;
				if(!response.data.success){
					gerarVinculoMoip();
				}
			});
		}

		function gerarVinculoMoip(){
			$http.get('system/public/moip/connect')
			.then(function(response){
				if(response.data.success){
					vm.link_botao = response.data.object;
				}
			});
		}

		function getSolds(){
			$http.get('system/public/store/solds')
			.then(function(response){
				if(response.data.success){
					vm.vendidos = response.data.object;
				}
			});
		}

		function getEvaluations(){
			$http.get('system/public/evaluations/get')
			.then(function(response){
				if(response.data.success){
					vm.avaliacoes = response.data.object;
				}
				else{
					console.log(response.data.error);
				}
			});
		}
		
		function getActiveProducts(){
			$http.get('system/public/store/active')
			.then(function(response){
				if(response.data.success){
					vm.ativos = response.data.object;
				}
			});
		}

		function getNonActiveProducts(){
			$http.get('system/public/store/noActive')
			.then(function(response){
				if(response.data.success){
					vm.desativados = response.data.object;
				}
			});
		}
		
	};
})();
