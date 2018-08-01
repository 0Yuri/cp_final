(function () {
	'use strict';

	angular.module ('app')

	.controller ('ExperimentalController', ExperimentalController);

	function ExperimentalController ($state, $http, $window){
		// Variables
		var vm = this;
		vm.msg_error = "";

		// Methods
		vm.verificarEmail = verificarEmail;
		vm.textChanged = textChanged;

		_init();

		function _init(){
		}

		function verificarEmail(info){
			console.log(info);
			return;
			// $http.post('system/public/')
			// .then(function(response){
			// 	if(response.data.success){
			// 		alert("Tudo certo");
			// 	}
			// 	else{
			// 		vm.msg_error = response.data.error;
			// 	}
			// });
		}

		function cadastrarPessoal(info){

		}

		function cadastrarEnderecos(info){

		}

		function cadastrarMoip(info){
			
		}

		
		function textChanged(input){
			if(input.cep.length >= 9){
				cepAddress(input);
			}
		};

		function cepAddress(cep){
			$http.post('system/public/address/getForSignup', cep)
			.then(function(response){
				if(response.data.success){
					vm.address = response.data.object;
				}
				else{
					alert("Não foi possível encontrar informações referentes à este CEP, digite o endereço manualmente.");
				}
			});
		}

	}
})();
