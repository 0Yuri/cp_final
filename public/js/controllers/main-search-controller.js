(function () {
	'use strict';

	angular.module ('app')

	.controller ('SearchController', SearchController);

	function SearchController ($state, $http, $stateParams){
		var vm = this;
    vm.pesquisa = pesquisa;
		vm.products_error = "Pesquisando produtos...";
		vm.stores_error = "Pesquisando lojas...";

    _init();

    function _init(){
      pesquisa();
    }


    function pesquisa(){
      $http.post('system/public/search', $stateParams)
      .then(function(response){
        if(response.data.object){
					vm.products = response.data.object.products;
					if(!vm.products.success){
						vm.products_error = "Nenhum produto foi encontrado.";
					}
					vm.stores = response.data.object.stores;
					if(!vm.stores.success){
						vm.stores_error = "Nenhuma loja foi encontrada.";
					}
        }
				else{
					vm.error = response.data.error;
				}
      });
    }

  }
})();
