(function () {
	'use strict';

	angular.module ('app')

	.controller ('StoresController', StoresController);

	function StoresController ($state, $http, $stateParams){
		var vm = this;
    vm.pegarLoja = pegarLoja;
    vm.lojas = [];
    vm.msg = "Consultando lojas..."

		_init();

	 function _init () {
     pegarLoja();
	 }

   function pegarLoja(){
     $http.get('system/public/stores/getStores')
     .then(function(response){
       if(response.data.success){
         vm.lojas = response.data.object;
       }else{
         vm.msg = "Nenhuma loja ativa foi encontrada.";
       }
     });
   }


	}
})();
