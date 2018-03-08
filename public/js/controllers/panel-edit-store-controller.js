(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelEditStoreController', PanelEditStoreController);

	function PanelEditStoreController ($state, $http, $scope, $stateParams){
		var vm = this;
		vm.updateStore = updateStore;
		vm.getStore = getStore;
		vm.changePic = changePic;
		vm.changeBanner = changeBanner;

		_init();

		function _init(){
			getStore();
		}

		function changePic(store){
			var fd = new FormData();
			fd.append('imagem', $scope.myFile);
			fd.append('loja', store.id);
			$http.post('system/public/store/change_picture', fd,{
				transformRequest: angular.identity,
				headers: {'Content-Type':undefined}
			}).then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			})
		}

		function changeBanner(store){
			if($scope.bannerFile == null){
				return;
			}
			else{
				var fd = new FormData();
				fd.append('imagem', $scope.bannerFile);
				fd.append('loja', store.id);

				$http.post('system/public/store/change_banner', fd,{
					transformRequest: angular.identity,
					headers:{'Content-Type':undefined}
				}).then(function(response){
					if(response.data.success){
						$state.reload();
					}
					else{
						alert(response.data.error);
					}
				})

			}
		}

		function getStore(){
			$http.get('system/public/store/logged_store')
			.then(function(response){
				if(response.data.success){
					vm.loja = response.data.object;
				}else{
					alert(response.data.error);
				}
			});
		}

    function updateStore(field){
			// Atualiza a loja
      $http.post('system/public/store/update_store', field)
      .then(function(response){
        if(response.data.success){
          $state.go('root.panel.store', {}, {reload : "root.panel.store"});
        }else{
          alert(response.data.error);
        }
      });
    }

  }
})();
