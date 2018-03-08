(function () {
	'use strict';

	angular.module ('app')

	.controller ('StoresController', StoresController);

	function StoresController ($state, $http, $stateParams){
		var vm = this;
    vm.pegarLoja = pegarLoja;

		_init();

	 ///////// Functions /////////

	 function _init () {
     pegarLoja();
	 }

   function pegarLoja(){
     $http.get('system/public/stores/get_stores')
     .then(function(response){
       if(response.data.success){
         vm.lojas = response.data.object;
       }else{
         vm.lojas = ['Nenhuma loja foi encontrada.'];
         console.log(response.data.error);
       }
     });
   }


	}
})();
