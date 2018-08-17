(function () {
	'use strict';

	angular.module ('app')

	.controller ('TerceirosController', TerceirosController);

	function TerceirosController ($state, $http, $scope, $stateParams){
        var vm = this;
		_init();
		
		function _init(){
			console.info($stateParams);
			if($stateParams.code != null){
				enviarToken($stateParams);
			}
		}

		function enviarToken(token){
			$http.post('system/public/moip/vincula', token)
			.then(function(response){
				if(response.data.success){
					alert("vinculado");
				}
				else{
					console.log(response.data.error);
				}
			})
		}
    }
})();
