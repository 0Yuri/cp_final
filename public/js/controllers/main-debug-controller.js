(function () {
	'use strict';

	angular.module ('app')

	.controller ('DebugController', DebugController);

	function DebugController ($state, $http, $scope, $stateParams, fileUploadService, testService){
		var vm = this;
		vm.upload = upload;
		vm.teste = {
			nome: "Yves",
			description: "Testes",
			idade: 44
		};

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


  }
})();
