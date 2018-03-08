(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelWithDrawController', PanelWithDrawController);

	function PanelWithDrawController ($state, $http, userService){
		var vm = this;
    vm.pegarSaldo = pegarSaldo;
		vm.sacarDinheiro = sacarDinheiro;

		_init();
		///////// Functions /////////
		function _init () {
      pegarSaldo();
		}

    function pegarSaldo(){
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

		function sacarDinheiro(input){
			$http.post('system/public/moip/withdraw', input)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			});
		}

 };
})();
