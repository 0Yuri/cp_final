(function () {
	'use strict';

	angular.module ('app')

	.controller ('SignupController', SignupController);

	function SignupController ($state, $http, $window){
		var vm = this;

		vm.link = "about:blank";
		vm.msg_error = "";

		vm.field = {
			name: "Yves",
			last_name: "Gregorio",
			gender: "male",
			birthdate: "1994-04-12",
			email: "yveshenr@gmail.com",
			cpf: "99999999999",
			rg: "9999999",
			issuer: "sds",
			issue_date: "2010-10-23",
			password: "123"
		};
		vm.contact = {
			ddd_1: "81",
			tel_1: "99999999",
			ddd_2: "81",
			tel_2: "99999999"
		};

		vm.cadastrarUsuario = cadastrarUsuario;

		vm.cepAddress = cepAddress;
		vm.textChanged = textChanged

		function cadastrarUsuario(){
			var fields = {
				address_info: vm.address,
				user_info: vm.field,
				contact_info: vm.contact
			};
			$http.post('system/public/user/signup', fields)
			.then(function(response){
				if(response.data.success){
					alert("Sucesso!");
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
					vm.address = response.data.object;
				}
				else{
					alert("Não foi possível encontrar informações referentes à este CEP, digite o endereço manualmente.");
				}
			});
		}

	}
})();
