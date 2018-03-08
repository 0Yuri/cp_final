(function () {
	'use strict';

	angular.module ('app')


	.controller ('PanelCreateStoreController', PanelCreateStoreController);


	function PanelCreateStoreController ($state, $http, $scope){
		var vm = this;
    vm.criarLoja = criarLoja;
		vm.teste = teste;

		function teste(){
			console.info($scope.profilePicture);
		}

    function criarLoja(loja) {
			var fd = new FormData();
			fd.append('image', $scope.profilePicture);
			fd.append('name', loja.name);
			fd.append('ddd', loja.ddd);
			fd.append('phone', loja.phone);
			fd.append('description', loja.description);

			$http.post('system/public/store/new_store', fd,{
				transformRequest: angular.identity,
				headers: {'Content-Type':undefined}
			}).then(function(response){
				if(response.data.success){
					$state.go('root.panel.store.view');
				}
				else{
					alert(response.data.error);
				}
			})
    }
  }

})();
