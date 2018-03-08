(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelHomeController', PanelHomeController);

	function PanelHomeController ($scope, $state, $http){

		$scope.freeze = function(){
			console.log("Lojinha congelada com sucesso");
		}


	}
})();
