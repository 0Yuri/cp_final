(function () {
	'use strict';

	angular.module ('app')

	.controller ('ProductController', ProductController);

	function ProductController ($state, $http, $pathTo, $rootScope, userService, $stateParams){
		var vm = this;

    vm.getProduto = getProduto;
		vm.adicionarCarrinho = adicionarCarrinho;
		vm.perguntar = perguntar;
		vm.pegarPerguntas = pegarPerguntas;
		vm.favoritar = favoritar;
    vm.produto;

		_init();

		///////// Functions /////////
		function _init() {
      getProduto();
			pegarPerguntas();
		}

		function favoritar(){
			$http.post('system/public/favorites/add', $stateParams)
			.then(function(response){
				if(response.data.success){
					alert('Adicionado com sucesso. Confira depois nos seus favoritos.');
				}else{
					alert(response.data.error);
				}
			});
		}

		function perguntar(field){
			var dados = {
				pergunta:field,
				produto: $stateParams
			};
			$http.post('system/public/question/ask', dados)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}else{
					alert(response.data.error);
				}
			});
		}

		function adicionarCarrinho(field){
			$http.post('system/public/cart/add', field)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}else{
					alert(response.data.error);
				}
			});
		}

		function pegarPerguntas(){
			$http.post('system/public/question/getQuestions', $stateParams)
			.then(function(response){
				if(response.data.success){
					vm.perguntas = response.data.object;
				}else{
					console.log(response.data.error);
				}
			});
		}

		function getProduto(){
      $http.post('system/public/product/get', $stateParams)
      .then(function(response){
        if(response.data.success){
          vm.produto = response.data.object;
					vm.produto.quantity = 1;
        }else{
          alert(response.data.error);
        }
      });
    }

}
})();
