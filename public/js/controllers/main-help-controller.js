(function () {
	'use strict';

	angular.module ('app')

	.controller ('HelpController', HelpController);

	function HelpController ($state, $http, $stateParams){
		var vm = this;
    vm.fale_conosco = fale_conosco;


    function fale_conosco(){
      $http.post('system/public/contact/contact_us', vm.message)
      .then(function(response){
        if(response.data.success){
          alert('Agradecemos e entraremos em contato em breve!');
					vm.message = null;
        }else{
          vm.msg = response.data.error;
        }
      });
    }

  }
})();
