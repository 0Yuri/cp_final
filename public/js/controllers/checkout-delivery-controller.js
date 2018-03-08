(function () {
	'use strict';

	angular.module('app')
	.controller ('CheckoutDeliveryController', CheckoutDeliveryController);

	function CheckoutDeliveryController($state, $http, $stateParams){
		var vm = this;
		vm.pegarPedidos = pegarPedidos;
		vm.definirEntrega = definirEntrega;
		vm.cepAddress = cepAddress;
		vm.textChanged = textChanged;
		vm.page = page;
		vm.pedidos;
		vm.exibir;
		vm.error = "Consultado seus pedidos...";

		_init();

		function _init(){
			vm.pedidos = {};
			vm.exibir = 0;
			pegarPedidos();
		}

		function page(valor){
			vm.exibir += valor;
		}

		function textChanged(input){
			if(input.info.cep.length >= 9){
				cepAddress(input);
			}
		};

		function cepAddress(cep){
			$http.post('system/public/address/get', cep)
			.then(function(response){
				if(response.data.success){
					cep.info = response.data.object;
				}
				else{
					alert('Ocorreu um erro ao receber o endereço do cep inserido.');
				}
			});
		}

		function pegarPedidos(){
			$http.get('system/public/checkout/pegar_pedidos')
			.then(function(response){
				if(response.data.success){
					vm.pedidos = response.data.object;
					vm.error = "";
				}
				else{
					vm.pedidos = {};
					vm.error = response.data.error;
				}
			})
		}

		function definirEntrega(info){
			$http.post('system/public/checkout/definir_entregas', info)
			.then(function(response){
				if(response.data.success){
					$state.go('root.checkout.review');
				}
				else{
					alert(response.data.error);
				}
			});
		}

	}
})();
