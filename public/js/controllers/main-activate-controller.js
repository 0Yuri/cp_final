(function () {
	'use strict';

	angular.module ('app')

	.controller ('ActivateController', ActivateController);

	function ActivateController ($state, $http, $scope, $stateParams){
        var vm = this;
        vm.activate = activate;
        vm.message;        

        _init();

        function _init(){
            activate($stateParams.token);
        }

        function activate(token){
            var post = {
                'token': token
            };
            $http.post('system/public/user/activate', post)
            .then(function(response){
                if(response.data.success){
                    vm.message = "Você ativou sua conta com sucesso, agora é só realizar o login e começar a aproveitar!";
                }
                else{
                    vm.msg_error = response.data.error;
                }
            });
        }

    }
})();
