(function () {
	'use strict';

	angular.module ('app')

	.controller ('ViewStoreController', ViewStoreController);

	function ViewStoreController ($state, $http, $stateParams){
		var vm = this;

		vm.pegarLoja = pegarLoja;
		vm.pegarProdutos = pegarProdutos;
		vm.pegarQtdVendas = pegarQtdVendas;

		vm.msg = "Consultando os produtos..."
		vm.produtos_vendidos;

		_init();

	 ///////// Functions /////////
	 function _init () {
		 pegarLoja();
		 pegarProdutos();
	 }

	 function pegarLoja(){
		 $http.post('system/public/stores/getStore', $stateParams)
		 .then(function(response){
			 if(response.data.success){
				 vm.loja = response.data.object;
				 pegarQtdVendas(vm.loja);
			 }
			 else{
				 console.log(response.data.error);
			 }
		 }).catch(function(error){
			 console.log('Error');
		 });
	 }

	 function pegarProdutos(){
		 $http.post('system/public/store/storeProducts', $stateParams)
		 .then(function(response){
			 if(response.data.success){
				 vm.produtos = response.data.object;
			 }else{
				 vm.msg = "Nenhum produto foi encontrado.";
				 console.log(response.data.error);
			 }
		 });
	 }

	 function pegarQtdVendas(info){
		 $http.post('system/public/store/soldProducts', info)
		 .then(function(response){
			 if(response.data.success){
				 vm.produtos_vendidos = response.data.object;
			 }
			 else{
				 console.log("Erro ao receber a quantidade de produtos vendidos.");
			 }
		 });
	 }

	}
})();
