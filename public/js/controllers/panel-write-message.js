(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelWriteMessageController', PanelWriteMessageController);

    function PanelWriteMessageController ($rootScope, $http, $stateParams){
        var vm = this;
        vm.pegarDestinatario = pegarDestinatario;
        vm.escreverMensagem = escreverMensagem;

        _init();

        ///////// Functions /////////

        function _init () {
          pegarDestinatario();
        }

        function pegarDestinatario(){
          $http.get('system/public/user/destiny/'+$stateParams.id)
          .then(function(response){
            if(response.data.success){
              vm.destinatario = response.data.object;
              vm.message.destiny = response.data.object.name_id;
            }
            else{
              alert(response.data.error);
            }
          });
        }

        function escreverMensagem(info){
          console.info(info);
        }
    }
})();
