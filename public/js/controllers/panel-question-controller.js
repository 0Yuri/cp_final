(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelQuestionController', PanelQuestionController);

    function PanelQuestionController ($rootScope, $http, $state){
        var vm = this;
        vm.pegarPerguntas = pegarPerguntas;
        vm.setPage = setPage;

        vm.status;
        vm.error = "Consultando perguntas pendentes...";
        vm.pagina;
        vm.paginas;

        _init();

        function _init(){
          vm.status;
          vm.pagina = vm.paginas = 0;
          pegarPerguntas();
        }

        function pegarPerguntas(){
          var content = {
            page: vm.pagina
          };
          $http.post('system/public/question/getActiveQuestions', content)
          .then(function(response){
            vm.status = response.data.success;
            if(response.data.success){
              vm.perguntas = response.data.object.perguntas;
              vm.paginas = response.data.object.paginas;
            }else{
              vm.error = response.data.error;
            }
          });
        }

        function setPage(value){
          vm.pagina += value;
          pegarPerguntas();
        }
    }
})();
