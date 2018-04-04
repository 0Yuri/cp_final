(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelSaleController', PanelSaleController);

    function PanelSaleController ($rootScope, $http, $stateParams, $state){
        var vm = this;
        vm.cadastrarRastreio = cadastrarRastreio;
        vm.enviarMensagem = enviarMensagem;
        vm.pegarChat = pegarChat;
        vm.checkComprador = checkComprador;
        vm.checkVendedor = checkVendedor;
        vm.avaliarComprador = avaliarComprador;

        _init();

        ///////// Functions /////////
        function _init(){
          pegarVenda($stateParams);
          pegarChat($stateParams);
          checkComprador($stateParams);
          checkVendedor($stateParams);
        }

        function avaliarComprador(info){
          var post = {
            avaliacao: info,
            pedido: $stateParams.id
          };
          $http.post('system/public/order/evaluateBuyer', post)
          .then(function(response){
            if(response.data.success){
              $state.reload();
            }
            else{
              console.log(response.data.error);
            }
          })
        }

        function checkComprador(info){
          $http.post('system/public/order/getBuyerStatus', info)
          .then(function(response){
            vm.avaliou = response.data.success;
            if(response.data.success){
              vm.avaliacao = response.data.object;
            }
            else{
              console.log(response.data.error);
            }
          })
        }

        function checkVendedor(info){
          $http.post('system/public/order/getSellerStatus', info)
          .then(function(response){
            vm.fuiavaliado = response.data.success;
            if(response.data.success){
              vm.minhaavaliacao = response.data.object;
            }
            else{
              console.log(response.data.error);
            }
          })
        }

        function enviarMensagem(info){
          var content = {
            order: $stateParams,
            info: info
          };
          $http.post('system/public/order/sendMessage', content)
          .then(function(response){
            if(response.data.success){
              pegarChat($stateParams);
            }
            else{
              alert(response.data.error);
            }
          })
        }

        function pegarChat(info){
          $http.post('system/public/order/getChat', info)
          .then(function(response){
            if(response.data.success){
              vm.messages = response.data.object;
            }
            else{
              console.log(response.data.error);
            }
          })
        }

        function cadastrarRastreio(info){
          $http.post('system/public/orders/tracking', info)
          .then(function(response){
            if(response.data.success){
              $state.reload();
            }
            else{
              console.log(response.data.error);
            }
          })
        }

        function pegarVenda(info){
          $http.post('system/public/orders/sellOrder', info)
          .then(function(response){
            if(response.data.success){
              vm.pedido = response.data.object;
            }
            else{
              console.log(response.data.error);
            }
          })
        }
      }
    }
  )();
