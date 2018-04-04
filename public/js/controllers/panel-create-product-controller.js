(function () {
	'use strict';

	angular.module ('app')

	.controller ('CreateProductController', CreateProductController);

	function CreateProductController ($state, $http, $stateParams, $scope){
		var vm = this;
		vm.msg_error;

		vm.criarProduto = criarProduto;
		vm.pegarCategorias = pegarCategorias;
		vm.pegarMarcas = pegarMarcas;

		vm.field = {};
		vm.field.stock = 1;

		_init();

		function _init(){
			pegarCategorias();
			pegarMarcas();
		}

		function pegarCategorias(){
			$http.get('system/public/categories/getCategories')
			.then(function(response){
				if(response.data.success){
					vm.categorias = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		};

		function pegarMarcas(){
			$http.get('system/public/brands/getBrands')
			.then(function(response){
				if(response.data.success){
					vm.marcas = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		};

		function criarProduto(){
			var fd = new FormData();
			console.info($scope.myFile);
			fd.append('imagem', $scope.myFile);
			fd.append('name', vm.field.name);
			fd.append('category_id', vm.field.category_id);
			fd.append('brand_id', vm.field.brand_id);
			fd.append('gender', vm.field.gender);
			fd.append('description', vm.field.description);
			fd.append('quality', vm.field.quality);
			fd.append('price', vm.field.price);
			fd.append('original_price', vm.field.original_price);
			fd.append('shipping', vm.field.shipping);
			fd.append('local', vm.field.local);
			fd.append('height', vm.field.height);
			fd.append('width', vm.field.width);
			fd.append('length', vm.field.length);
			fd.append('weight', vm.field.weight);
			fd.append('stock', vm.field.stock);


			$http.post('system/public/product/add', fd, {
				transformRequest: angular.identity,
				headers: {'Content-Type':undefined}
			}).then(function(res){
				if(res.data.success){
					$state.go('root.panel.dashboard');
				}
				else{
					alert(res.data.error);
				}
			})
		}

}})();
