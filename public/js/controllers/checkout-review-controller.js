(function () {
	'use strict';


	angular.module('app')

	.controller ('CheckoutReviewController', CheckoutReviewController);

	function CheckoutReviewController($state, $http){
		var vm = this;
    vm.getOrders = getOrders;
    vm.confirmarPedidos = confirmarPedidos;
		vm.calcularEntrega = calcularEntrega;

    _init();

    function _init(){
      getOrders();
    }

		function calcularEntrega(info, valores){
			var content = {
				info, valores
			};
			$http.post('system/public/checkout/frete', content)
			.then(function(response){
				if(response.data.success){
					valores.valores = response.data.object;
				}
				else{
					alert(response.data.error);
				}
			});
		}

    function getOrders(){
      $http.get('system/public/checkout/revisar_pedido')
      .then(function(response){
        if(response.data.success){
          vm.pedidos = response.data.object;
        }
        else{
          alert(response.data.error);
        }
      })
    }

    function confirmarPedidos(info){
      $http.post('system/public/checkout/finalizar', info)
			.then(function(response){
				if(response.data.success){
					$state.go('root.checkout.payment');
				}
				else{
					alert(response.data.error);
				}
			})
    }

  }
})();
