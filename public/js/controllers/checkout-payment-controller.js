(function () {
	'use strict';


	angular.module('app')

	.controller ('CheckoutPaymentController', CheckoutPaymentController);

	function CheckoutPaymentController($state, $http, $stateParams){
		var vm = this;
		vm.msg_status = "";
		
		
		_init();

		vm.pagarComCartao = pagarComCartao;
		vm.pagarComBoleto = pagarComBoleto;

		function _init(){
			getParcelas();
		}

		function getParcelas(){
			$http.get('system/public/cart/parcelas')
			.then(function(response){
				if(response.data.success){
					vm.parcelas = response.data.object;
				}
				else{
					alert('Erro ao calcular máximo de parcelas');
				}
			});
		}

		function pagarComCartao(info){
			$('#waitingModal').modal('show');
			$http.post('system/public/checkout/cartao', info)
			.then(function(response){
				if(response.data.success){
					vm.msg_status = "Sua compra foi realizada com sucesso.";
				}
				else{
					alert(response.data.error);
				}
				$('#waitingModal').modal('hide');
			});
		}

		function pagarComBoleto(){
			$('#waitingModal').modal('show');
			$http.get('system/public/checkout/boleto')
			.then(function(response){
				if(response.data.success){
					vm.boleto_view = response.data.success;
					vm.boleto_facil = response.data.object;
				}else{
					alert(response.data.error);
				}
				$('#waitingModal').modal('hide');
			});
		}

	}

})();
