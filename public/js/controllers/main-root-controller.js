(function () {
	'use strict';

	angular.module ('app')

	.controller ('RootController', RootController);

	function RootController ($state, $http, $pathTo, $rootScope, userService) {
		var vm = this;
		$rootScope.imgFolder = $pathTo.imgFolder;

		vm.pegarCategorias = pegarCategorias;
		vm.pegarQtdCarrinho = pegarQtdCarrinho;

		vm.login = login;
		vm.logout = logout;
		vm.verificarSessao = verificarSessao;

		vm.session_status = false;

		_init();

		///////// Functions /////////
		function _init() {
			var marginTopSize = $(".fixed-header").height();
			$(document).ready(function(){
				$(".margin-fixed-top").css("margin-top", marginTopSize+"px");
			});

			pegarCategorias();
			pegarQtdCarrinho();
			verificarSessao();
			teste();
		}

		function teste(){
		}

		function verificarSessao(){
			$http.get('system/public/user/session')
			.then(function(response){
				vm.session_status = response.data.success;
			});
		}

		function login (input) {
			userService.login (input)
				.then(function (data) {
					$('#loginModal').modal('hide');
					$state.go('root.panel.dashboard');
					vm.session_status = true;
					pegarQtdCarrinho();
				}, function (error) {
					alert(error);
				});
		}

		function logout(){
			$http.get('system/public/user/logout')
			.then(function(response){
				if(response.data.success){
					$state.reload();
					vm.session_status = false;
				}else{
					console.log("Erro ao realizar o logout.");
				}
			});
		}

		function pegarQtdCarrinho(){
			$http.get('system/public/cart/productsCart')
			.then(function(response){
				if(response.data.success){
					vm.numero_carrinho = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		}

		function pegarCategorias() {
			$http.get('system/public/categories/getCategories')
			.then(function(response){
				if(response.data.success){
					vm.produtos = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		}

	}


	function isMobile () {
		var userAgent = navigator.userAgent.toLowerCase();
		if( userAgent.search(/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i)!= -1 )
			return true;
	}
})();
