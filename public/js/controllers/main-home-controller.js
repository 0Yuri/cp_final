(function () {
	'use strict';

	angular.module('app')

	.controller ('HomeController', HomeController);

	function HomeController ($scope, $state, $http){
		var vm = this;
		vm.lojasDestaque = lojasDestaque;
		vm.produtosDestaque = produtosDestaque;

		vm.home = "HOME";

		_init();

		///////// Functions /////////
		function _init() {
			lojasDestaque();
			produtosDestaque();
		}

		function lojasDestaque(){
			$http.get('system/public/store/featured')
			.then(function(response){
				if(response.data.success){
					vm.featuredStores = response.data.object;
				}
				else{
					console.log(response.data.error);
				}
			});
		}

		function produtosDestaque(){
			$http.get('system/public/product/featured')
			.then(function(response){
				if(response.data.success){
					vm.featuredProducts = response.data.object;
				}
				else{
					console.log(response.data.error);
				}
			});
		}

	}
})();
