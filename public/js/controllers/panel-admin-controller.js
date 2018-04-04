(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelAdminController', PanelAdminController);

    function PanelAdminController ($rootScope, $http, $state, $stateParams){
        var vm = this;
        vm.usuarios = [];
        vm.getInfo = getInfo;
        // User related
        vm.pesquisarUsuario = pesquisarUsuario;
        vm.banirUsuario = banirUsuario;
        vm.desbanirUsuario = desbanirUsuario;
        vm.visualizarUsuario = visualizarUsuario;
        // Store related
        vm.pesquisarLoja = pesquisarLoja;
        vm.toggleLoja = toggleLoja;
        vm.visualizarLoja = visualizarLoja;
        // Stats
        vm.estatisticas = estatisticas;

        vm.stats = {
          boleto: 0,
          cartao: 0,
          sedex: 0,
          pac: 0,
          total:0
        };

        _init();

        function _init(){
          getInfo();
        }

        function getInfo(){
          $http.get('system/public/user/checkStatus')
          .then(function(response){
            vm.status = response.data.success;
            if(response.data.success){

            }
            else{
              console.log(response.data.error);
            }
          })
        }

        // Usuários
        function pesquisarUsuario(info){
          $http.post('system/public/admin/users/search', info)
          .then(function(response){
            vm.user = false;
            if(response.data.success){
              vm.usuarios = response.data.object;
            }
            else{
              alert(response.data.error);
            }
          })
        }
        function banirUsuario(info){
          $http.post('system/public/admin/users/ban', info)
          .then(function(response){
            vm.user = false;
            if(response.data.success){
              alert("Usuário banido com sucesso.");
            }
            else{
              alert(response.data.error);
            }
          })
        }
        function desbanirUsuario(info){
          $http.post('system/public/admin/users/unban', info)
          .then(function(response){
            vm.user = false;
            if(response.data.success){
              alert("Usuário desbanido com sucesso.");
            }
            else{
              alert(response.data.error);
            }
          })
        }
        function visualizarUsuario(info){
          vm.user = info;
        }

        // Lojas
        function pesquisarLoja(info){
          $http.post('system/public/admin/stores/search', info)
          .then(function(response){
            vm.store = false;
            if(response.data.success){
              vm.stores = response.data.object;
            }
            else{
              alert(response.data.error);
            }
          });
        }
        function toggleLoja(info){
          $http.post('system/public/admin/lojas/toggleStatus', info)
          .then(function(response){
            vm.store = false;
            if(response.data.success){
              $state.reload();
            }
            else{
              alert(response.data.error);
            }
          });
        }
        function visualizarLoja(info){
          vm.store = info;
        }

        // Compras
        function estatisticas(){
          $http.get('system/public/admin/stats')
          .then(function(response){
            if(response.data.success){
              vm.stats = response.data.object;
            }
            else{
              alert(response.data.error);
            }
          });
        }

    }
})();
