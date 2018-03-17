(function () {
	'use strict';

	angular.module ('app')

	.controller ('MyAccountController', MyAccountController);

	function MyAccountController ($state, $http){
		var vm = this;
		vm.atualizarDados = atualizarDados;

		_init();

		///////// Functions /////////

		function _init () {
			// TODO
			getUserInfo();
		}

		function getUserInfo () {
			$http.get('system/public/user/logged_user')
			.then(function(response){
				if(response.data.success){
					vm.user = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		};

		function atualizarDados(){
			$http.post('system/public/user/update', vm.user)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}else{
					vm.msg_status = response.data.error;
				}
			});
		};
	}
})();
