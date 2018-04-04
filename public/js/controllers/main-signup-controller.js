(function () {
	'use strict';

	angular.module ('app')

	.controller ('SignUpController', SignUpController);

	function SignUpController ($state, $http, $window){
		var vm = this;
		vm.cadastrarUsuario = cadastrarUsuario;
		vm.cepAddress = cepAddress;
		vm.textChanged = textChanged

		function cadastrarUsuario(){
			var field = {
				user_info: vm.field,
				address_info: vm.address
			};
      $http.post('system/public/user/signup', field)
      .then(function(response){
        if(response.data.success){
          $window.alert("Cadastrado com sucesso.");
					$state.go('root.home');
        }else{
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
					console.log("Cep inválido, digite o endereço manualmente.");
				}
			});
		}

	}
})();
