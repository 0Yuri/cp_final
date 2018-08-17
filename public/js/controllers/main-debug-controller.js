(function () {
	'use strict';

	angular.module ('app')

	.controller ('DebugController', DebugController);

	function DebugController ($state, $http, $scope, $stateParams, fileUploadService, testService){
		var vm = this;
		vm.upload = upload;
		vm.link;

		_init();

		function _init(){
			linkar();
		}

		function upload (file) {
			var fd = new FormData();
			fd.append('file',$scope.myFile);
			fd.append('name', vm.teste.nome);
			fd.append('description', vm.teste.description);
			fd.append('idade', vm.teste.idade);

			$http.post('system/public/store/criar', fd, {
				transformRequest: angular.identity,
				headers: {'Content-Type':undefined}
			});
		}

		function linkar(){
			$http.get('system/public/moip/connect')
			.then(function(response){
				if(response.data.success){
					vm.link = response.data.object;
				}
				else{
					alert("Erro");
				}
			});
		}


  }
})();