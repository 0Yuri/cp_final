(function () {
	'use strict';

	angular.module ('app')

	.controller ('SignupController', SignupController);

	function SignupController ($state, $http){
		var vm = this;

		vm.link = "about:blank";
		vm.msg_error = "";
		vm.msg_process_modal = "Tudo certo.";

		vm.field = {
			name: "Yves",
			last_name: "Gregorio",
			gender: "male",
			birthdate: "12-04-1994",
			email: "yveshenr@gmail.com",
			cpf: "50342052039",
			rg: "9999999",
			issuer: "sds",
			issue_date: "23-10-2010",
			password: "123",
			confirmpassword: "123",
			ddd_1: "81",
			tel_1: "99999999",
			ddd_2: "81",
			tel_2: "99999999",
			cep: "",
			neighborhood: "",
			complement: "",
			number: "",
			reference: "",
			UF: ""
		};

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
