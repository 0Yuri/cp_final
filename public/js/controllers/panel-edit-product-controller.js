(function () {
	'use strict';

	angular.module ('app')

	.controller ('EditProductController', EditProductController);

	function EditProductController ($state, $http, $stateParams, $scope){
		var vm = this;
		vm.goto = goto;
		vm.uploadProfile = uploadProfile;
		vm.uploadSimple = uploadSimple;
		vm.removerImagem = removerImagem;

		vm.pegarProduto = pegarProduto;
		vm.pegarCategorias = pegarCategorias;
		vm.pegarMarcas = pegarMarcas;
		vm.alterarProduto = alterarProduto;

    _init();

    function _init(){
      pegarProduto();
			pegarCategorias();
			pegarMarcas();
    }

		function goto(state, field){
			$state.go(state, field);
		}

		function uploadProfile(info){
			var fd = new FormData();
			fd.append('imagem', $scope.profilePic);
			fd.append('produto', info.id);
			$http.post('system/public/product/profile/add', fd,{
				transformRequest: angular.identity,
				headers: {'Content-Type': undefined}
			}).then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			});
		}

		function uploadSimple(info){
			var fd = new FormData();
			fd.append('imagem', $scope.extraPhoto);
			fd.append('produto', info.id);
			$http.post('system/public/product/extra/add', fd, {
				transformRequest: angular.identity,
				headers: {'Content-Type': undefined}
			}).then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			})
		}

		function removerImagem(image){
			$http.post('system/public/product/remover_image', image)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			})
		}

    function pegarProduto(){
      $http.post('system/public/product/getForEdit', $stateParams)
      .then(function(response){
        if(response.data.success){
          vm.produto = response.data.object;
        }else{
          alert(response.data.error);
        }
      });
    }

		function pegarCategorias(){
			$http.get('system/public/categories/getAll')
			.then(function(response){
				if(response.data.success){
					vm.categorias = response.data.object;
				}else{
					alert(response.data.error);
				}
			});
		}

		function pegarMarcas(){
			$http.get('system/public/brands/get_brands')
			.then(function(response){
				if(response.data.success){
					vm.marcas = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		}

    function alterarProduto(field){
      $http.post('system/public/product/update', field)
      .then(function(response){
        if(response.data.success){
          $state.go('root.panel.store');
        }else{
          alert(response.data.error);
        }
      });
    }


	};
})();
