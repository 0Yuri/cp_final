(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelController', PanelController);

	function PanelController ($state, $http, userService){
		var vm = this;
		vm.usuario;
		vm.getLogged = getLogged;

		userService.onlyUsers();

		vm.loadContent = loadContent;

		_init();

		///////// Functions /////////

		function _init () {
			getLogged();
		}

		function loadContent (state){
			switch(state){
				case 'account':
					vm.contentTitle = 'Conta';
					break;
				case 'editStore':
					vm.contentTitle = 'Editar Loja';
					break;
				case 'myaccount':
					vm.contentTitle = 'Minha conta';
					break;
				case 'purchaseHistory':
					vm.contentTitle = 'Histórico de Compras';
					break;
				case 'signup':
					vm.contentTitle = 'Cadastro';
					break;
				case 'questions':
					vm.contentTitle = 'Perguntas';
					break;
			}
			$state.go('root.panel.' + state, {}, {reload: 'root.panel.' + state});
		};

		function getLogged(){
			$http.get('system/public/user/logged_user')
			.then(function(response){
				if(response.data.success){
					vm.usuario = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		}

	};
})();
