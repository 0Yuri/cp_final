(function () {
	'use strict';

	angular.module ('app')

	.controller ('SignupController', SignupController);

	function SignupController ($state, $http){
		var vm = this;

		vm.field;
		vm.link = "about:blank";
		vm.msg_error = "";
		vm.msg_process_modal = "Tudo certo.";

		vm.cadastrarUsuario = cadastrarUsuario;
		vm.cepAddress = cepAddress;
		vm.textChanged = textChanged

		function cadastrarUsuario(field){
			$('#waitingModal').modal('show');
			$http.post('system/public/user/signup', field)
			.then(function(response){
				$('#waitingModal').modal('hide');
				if(response.data.success){
					$('#signupModal').modal('show');
					$state.go('root.home');
				}
				else{
					vm.msg_error = response.data.error;
				}
			});
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
					vm.field.street = response.data.object.street;
					vm.field.neighborhood = response.data.object.neighborhood;
					vm.field.UF = response.data.object.UF;
					vm.field.city = response.data.object.city;
				}
				else{
					alert("Não foi possível encontrar informações referentes à este CEP, digite o endereço manualmente.");
				}
			});
		}

	}
})();
