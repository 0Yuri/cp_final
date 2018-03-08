(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelMessageController', PanelMessageController);

    function PanelMessageController ($rootScope, $http, $stateParams){
        var vm = this;
        vm.pegarMensagem = pegarMensagem;
        vm.responderMensagem = responderMensagem;
        vm.apagarMensagem = apagarMensagem;

        _init();

        ///////// Functions /////////

        function _init () {
            pegarMensagem();
        }

        function pegarMensagem(){
          $http.post('system/public/message/get', $stateParams)
          .then(function(response){
            vm.msg_error = response.data.success;
            if(response.data.success){
              vm.mensagem = response.data.object;
            }
            else{
              vm.error = response.data.error;
            }
          });
        }

        function responderMensagem(){
        }

        function apagarMensagem(){
        }
    }
})();
