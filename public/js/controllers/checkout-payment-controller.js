(function () {
	'use strict';


	angular.module('app')

	.controller ('CheckoutPaymentController', CheckoutPaymentController);

	function CheckoutPaymentController($state, $http, $stateParams){
		var vm = this;

		vm.card = {
			name: 'JOSE F G SILVA',
			cvc: 123,
			expMonth: 12,
			expYear: 18,
			number: 5555666677778884
		};

		vm.pagarComCartao = pagarComCartao;
		vm.pagarComBoleto = pagarComBoleto;

		function pagarComCartao(info){
			$http.post('system/public/checkout/cartao', info)
			.then(function(response){
				if(response.data.success){
					console.log("Sucesso.");
				}
				else{
					// alert(response.data.error);
				}
			});
		}

		function pagarComBoleto(){
			$http.get('system/public/checkout/boleto')
			.then(function(response){
				if(response.data.success){
					vm.boleto_view = response.data.success;
					vm.boleto_facil = response.data.object;
					// console.log(response.data.object._links.checkout.payBoleto);
				}else{
					alert(response.data.error);
				}
			});
		}

	}

})();
