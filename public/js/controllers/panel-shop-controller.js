(function () {
	'use strict';

	angular.module ('app')

	.controller ('PanelShopController', PanelShopController);

	function PanelShopController ($state, $http, $stateParams){
		var vm = this;
		vm.pegarCompra = pegarCompra;
		vm.pegarId = pegarId;
		vm.pegarLoja = pegarLoja;
		vm.pagarPedido = pagarPedido;
		vm.pegarChat = pegarChat;
		vm.enviarMensagem = enviarMensagem;
		vm.avaliarVendedor = avaliarVendedor;
		vm.checkAvaliacao = checkAvaliacao;
		vm.minhaAvaliacao = minhaAvaliacao;

		_init();


		function _init(){
			pegarCompra($stateParams);
			pegarChat($stateParams);
			checkAvaliacao($stateParams);
			minhaAvaliacao($stateParams);
		}

		function checkAvaliacao(info){
			$http.post('system/public/order/getSellerStatus', info)
			.then(function(response){
				vm.avaliou = response.data.success;
				if(response.data.success){
					vm.avaliacao = response.data.object;
				}
				else{
					console.log(response.data.error);
				}
			});
		}

		function minhaAvaliacao(info){
			$http.post('system/public/order/getBuyerStatus', info)
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

		function pagarPedido(info){
			console.info(info);
		}

		function avaliarVendedor(info){
			var post = {
				avaliacao: info,
				pedido: $stateParams.id
			};
			$http.post('system/public/order/evaluateSeller', post)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			})
		}

		function enviarMensagem(info){
			var content = {
				order: $stateParams,
				info: info
			};
			$http.post('system/public/order/evaluateBuyer', content)
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

		function pegarId(info){
			console.info(info);
			$http.post('system/public/orders/id', info)
			.then(function(response){
				if(response.data.success){
					// console.log(response.data.object);
				}
				else{
					console.log("Erro ao adquirir o id.");
				}
			})
		}

		function pegarLoja(info){
			console.info(info);
			$http.post('system/public/orders/loja', info)
			.then(function(response){
				if(response.data.success){
					// console.log(response.data.object);
				}
				else{
					console.log("Erro ao adquirir o nome da loja.");
				}
			})
		}

		function pegarCompra(info){
			$http.post('system/public/orders/buyOrder', info)
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
})();
