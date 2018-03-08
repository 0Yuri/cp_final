(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelMessagesController', PanelMessagesController);

    function PanelMessagesController ($rootScope, $http, FileUploader){
        var vm = this;
        vm.mensagensEnviadas = mensagensEnviadas;
        vm.mensagensRecebidas = mensagensRecebidas;
        vm.setPage = setPage;

        // Mensagens
        vm.enviadas;
        vm.recebidas;
        // Quantidade de paginas
        vm.paginas_enviadas;
        vm.paginas_recebidas;
        // Paginas atuais
        vm.pagina_enviada;
        vm.pagina_recebida;

        _init();

        function _init () {
          vm.pagina_enviada = 0;
          vm.pagina_recebida = 0;
          mensagensRecebidas();
          mensagensEnviadas();
        }

        function setPage(type, value){
          if(type == 'enviada'){
            vm.pagina_enviada += value;
            mensagensEnviadas();
          }
          else{
            vm.pagina_recebida += value;
            mensagensRecebidas();
          }
        }

        function mensagensRecebidas(){
          var content = {
            page: vm.pagina_recebida
          };
          $http.post('system/public/message/received', content)
          // $http.get('system/public/message/received')
          .then(function(response){
            vm.recebidas_error = response.data.success;
            if(response.data.success){
              vm.recebidas = response.data.object.mensagens;
              vm.paginas_recebidas = response.data.object.paginas;
            }
            else{
              vm.error_1 = response.data.error;
            }
          });
        }

        function mensagensEnviadas(){
          var content = {
            page: vm.pagina_enviada
          };
          $http.post('system/public/message/sent', content)
          // $http.get('system/public/message/sent')
          .then(function(response){
            vm.enviadas_error = response.data.success;
            if(response.data.success){
              vm.enviadas = response.data.object.mensagens;
              vm.paginas_enviadas = response.data.object.paginas;
            }
            else{
              vm.error_2 = response.data.error;
            }
          });
        }
    }
})();
