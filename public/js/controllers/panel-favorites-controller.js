(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelFavoritesController', PanelFavoritesController);

	function PanelFavoritesController ($state, $http){
		var vm = this;
		vm.pegarFavoritos = pegarFavoritos;
		vm.removerFavorito = removerFavorito;
		vm.setPage = setPage;

		vm.status;
		vm.favorites_error = "Consultando favoritos...";

		vm.name = 'Usuário';
		vm.pagina;
		vm.paginas;

		_init();
		///////// Functions /////////

		function _init () {
			vm.pagina = 0;
			vm.paginas = 0;
			pegarFavoritos();
		}

		function setPage(valor){
			vm.pagina += valor;
			pegarFavoritos();
		}

		function pegarFavoritos(){
			var content = {
				page: vm.pagina
			};
			$http.post('system/public/favorites/get', content)
			.then(function(response){
				vm.status = response.data.success;
				if(response.data.success){
					vm.favorites = response.data.object.favoritos;
					vm.paginas = response.data.object.paginas;
				}
				else{
					vm.favorites_error = "Nenhum produto foi adicionado aos favoritos.";
					vm.pagina = 0;
					vm.paginas = 0;
				}
			});
		}

		function removerFavorito(input){
			$http.post('system/public/favorites/remove', input)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			})
		}
 };
})();
