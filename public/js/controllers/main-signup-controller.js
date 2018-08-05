(function () {
	'use strict';

	angular.module ('app')

	.controller ('SignupController', SignupController);

	function SignupController ($state, $http, $window){
		var vm = this;

		vm.link = "about:blank";
		vm.msg_error = "";

		vm.verificaEmail = verificaEmail;
		vm.cadastrarPessoal = cadastrarPessoal;
		vm.cadastrarEnderecos = cadastrarEnderecos
		vm.cepAddress = cepAddress;
		vm.textChanged = textChanged

		_init();

		function _init(){

		}

		function cadastrarEnderecos(field){
			$('#waitingModal').modal('show');
			$http.post('system/public/signup/address', field)
			.then(function(response){
				$('#waitingModal').modal('hide');
				if(response.data.success){					
					alert("Tudo ok");
				}
				else{
					$state.go('root.signup');
				}
			});
		}

		function cadastrarPessoal(field){
			$('#waitingModal').modal('show');
			$http.post('system/public/signup/personal', field)
			.then(function(response){
				$('#waitingModal').modal('hide');
				if(response.data.success){
					$state.go('root.enderecos');
				}
				else{
					$state.go('root.signup');
				}
			});
		}

		function verificaEmail(info){
			$http.post('system/public/signup/email', info)
			.then(function(response){
				if(response.data.success){
					$state.go('root.informacoes');
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
