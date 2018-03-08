(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelProductsController', PanelProductsController);

	function PanelProductsController ($rootScope, $http, FileUploader, $state){
		var vm = this;

		vm.categorias = [
			{name: 'Acessórios', value : 1}
		];
		vm.marcas = [
			{name: 'Marca 1', value: 1},
			{name: 'Marca 2', value: 2}
		];

		vm.login = login;
		vm.pegarCategorias = pegarCategorias;
		vm.pegarMarcas = pegarMarcas;
		vm.pegarProdutos = pegarProdutos;
		vm.removerProduto = removerProduto;
		vm.getStore = getStore;
		vm.uploader = new FileUploader({
			url: 'system/test/img_upload'
		});

		_init();

		///////// Functions /////////

		function _init () {
			// pegarCategorias();
			// pegarMarcas();
			pegarProdutos();
			getStore();
		}

		function login (field) {
			console.log(field);
		}

		function pegarCategorias(){
			$http.get('system/public/api/getCategories')
			.then(function(response){
				if(response.data.success){
					vm.categorias = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		}

		function pegarMarcas(){
			$http.get('system/public/api/getBrands')
			.then(function(response){
				if(response.data.success){
					vm.marcas = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		}

		function pegarProdutos(){
			$http.get('system/public/api/getOwnProducts')
			.then(function(response){
				if(response.data.success){
					vm.produtos_lista = response.data.object;
					console.log(vm.produtos_lista);
				}else{
					console.log(response.data.error);
				}
			});
		}

		function getStore(){
			$http.get('system/public/logged_store')
			.then(function(response){
				vm.store_status = response.data.success;
			});
		}

		function removerProduto(field){
			$http.post('system/public/delete_product', field)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}else{
					console.log(response.data.error);
				}
			});
		};

		// FILTERS

      vm.uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                console.log(vm.uploader.getReadyItems());
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        vm.uploader.onCompleteAll = function() {
            console.info(vm.uploader);
        };
	}
})();
