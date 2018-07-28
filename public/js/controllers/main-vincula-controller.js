(function () {
	'use strict';

	angular.module ('app')

	.controller ('TerceirosController', TerceirosController);

	function TerceirosController ($state, $http, $scope, $stateParams){
        var vm = this;   

        _init();

        function _init(){
            console.log($stateParams.code);
        }

    }
})();
