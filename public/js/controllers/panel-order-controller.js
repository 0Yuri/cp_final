(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelOrderController', PanelOrderController);

    function PanelOrderController ($rootScope, $http, $stateParams){
        var vm = this;
        vm.pegarPedido = pegarPedido;
        _init();

        ///////// Functions /////////
        function _init () {
            pegarPedido();
            pegarChat();
        }

        function pegarPedido(){
          $http.post('system/public/order/pegarPedido', $stateParams)
          .then(function(response){
            if(response.data.success){
              vm.pedido = response.data.object;
            }
            else{
              console.log(response.data.error);
            }
          });
        };

        function pegarChat(){
          $http.post('system/public/order/getChat', $stateParams)
          .then(function(response){
            if(response.data.success){
              vm.messages = response.data.object;
            }
            else{
              console.log(response.data.error);
            }
          });
        }

    }
})();
