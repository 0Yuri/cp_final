(function () {
	'use strict';

	angular.module ('app')

	.controller ('SignupController', SignupController);

	function SignupController ($state, $http, $window){
		var vm = this;

		vm.link = "about:blank";
		vm.msg_error = "";

		vm.verificaEmail = verificaEmail;
		vm.cadastrarUsuario = cadastrarUsuario;
		vm.cepAddress = cepAddress;
		vm.textChanged = textChanged

		_init();

		function _init(){
		}

		function cadastrarUsuario(){
			// $('#waitingModal').modal('show');
			$http.post('system/public/user/signup', field)
			.then(function(response){
				if(response.data.success){
					$('#waitingModal').modal('hide');
					$window.alert("Cadastrado com sucesso.");					
					$state.go('root.home');
				}
				else{
					vm.msg_error = response.data.error;
				}
			});
		}

		function verificaEmail(info){
			$http.post('system/public/user/checkemail', info)
			.then(function(response){
				if(response.data.success){
					$window.alert("Sucesso.");
				}
				else{
					vm.msg_error = response.data.error;
				}
			})
		}
		
		function gerarLinkMoip(){
			$http.get('system/public/moip/connect')
			.then(function(response){
				if(response.data.success){
					vm.link = response.data.object;
				}
				else{
					alert("Erro ao gerar link de autorização.");
				}
			});
		}

		function prosseguir(){

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
