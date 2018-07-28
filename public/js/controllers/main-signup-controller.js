(function () {
	'use strict';

	angular.module ('app')

	.controller ('SignupController', SignupController);

	function SignupController ($state, $http, $window){
		var vm = this;

		vm.link = "about:blank";

		vm.cadastrarUsuario = cadastrarUsuario;
		vm.cepAddress = cepAddress;
		vm.textChanged = textChanged

		_init();

		function _init(){
			gerarLinkMoip();
		}

		function cadastrarUsuario(){
			var field = {
				user_info: vm.field,
				address_info: vm.address
			};
			$('#waitingModal').modal('show');
      $http.post('system/public/user/signup', field)
      .then(function(response){
        if(response.data.success){
					$('#waitingModal').modal('hide');
					$window.alert("Cadastrado com sucesso.");					
					$state.go('root.home');
        }else{
          vm.msg_error = response.data.error;
        }
      });
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
