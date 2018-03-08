(function () {
	'use strict';


	angular.module('app')

	.controller ('CheckoutCartController', CheckoutCartController);

	function CheckoutCartController($state, $http){
		var vm = this;
		vm.setOrder = setOrder;
		vm.remover = remover;
		vm.calcularFrete = calcularFrete;
		vm.quantidade = quantidade;
		vm.pegarPedidos = pegarPedidos;
		vm.limparCarrinho = limparCarrinho;

		_init();

		function _init(){
			pegarPedidos();
		}

		function setOrder(){
			$http.get('system/public/checkout/definir_pedidos')
			.then(function(response){
				if(response.data.success){
					$state.go('root.checkout.info');
				}
				else{
					alert(response.data.error);
				}
			});
		}

		function remover(store_id, product_id){
			var post = {
				store : store_id,
				product : product_id
			};
			$http.post('system/public/cart/remove', post)
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			})
		}

		function calcularFrete(pedido){
			$http.post('system/public/cart/frete', pedido)
			.then(function(response){
				if(response.data.success){
					pedido.envio = response.data.object;
				}
				else{
					alert(response.data.error);
				}
			})
		}

		function quantidade(store_id, product_id, value){
			var content = {
				store: store_id,
				product: product_id,
				value: value
			};
			$http.post('system/public/cart/quantity', content)
			.then(function(response){
				if(response.data.success){
					pegarPedidos();
				}
				else{
					alert(response.data.error);
				}
			});
		}

		function pegarPedidos(){
			$http.get('system/public/cart/getCart')
			.then(function(response){
				if(response.data.success){
					vm.carrinho = response.data.object;
				}else{
					alert(response.data.error);
				}
			});
		}

		function limparCarrinho(){
			$http.get('system/public/cart/clear')
			.then(function(response){
				if(response.data.success){
					$state.reload();
				}
				else{
					alert(response.data.error);
				}
			});
		}

  }

})();
