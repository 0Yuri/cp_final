(function () {
	'use strict';

	angular.module ('app')

	.controller ('SearchProductsController', SearchProductsController);

	function SearchProductsController ($http, $stateParams){
		var vm = this;

		vm.search = $stateParams.search;

		_init();

	 ///////// Functions /////////

	 function _init () {
		 // TODO
	 }
	}
})();
