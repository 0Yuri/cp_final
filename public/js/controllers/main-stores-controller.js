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
         console.log(response.data.error);
       }
     });
   }


	}
})();
