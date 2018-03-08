(function () {
    'use strict';

    angular.module ('app')

    .controller ('PanelAnswerController', PanelAnswerController);

    function PanelAnswerController ($rootScope, $http, $state, $stateParams){
        var vm = this;
        vm.pegarPergunta = pegarPergunta;
        vm.responderPergunta = responderPergunta;
        vm.pergunta;

        _init();

        function _init(){
          pegarPergunta();
        }

        function pegarPergunta(){
          $http.post('system/public/question/getQuestion', $stateParams)
          .then(function(response){
            if(response.data.success){
              vm.pergunta = response.data.object;
            }
            else{
              console.log(response.data.error);
            }
          });
        }

        function responderPergunta(pergunta){
          $http.post('system/public/question/answer', pergunta)
          .then(function(response){
            if(response.data.success){
              $state.go('root.panel.questions');
            }
            else{
              console.log("Erro");
            }
          });
        }
    }
})();
