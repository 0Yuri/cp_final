(function () {
	'use strict';


	angular.module('app')

	.controller ('CheckoutMainController', CheckoutMainController);

	function CheckoutMainController($state, $http){
		var vm = this;
		vm.state = $state.current.url;
		vm.steps;
		_init();

		function _init(){
			switch($state.current.url){
				case '/checkout':
					$state.go('root.checkout.cart');
				case '/sacolinha':
					$state.go('root.checkout.cart');
					break;
				case '/entrega':
					$state.go('root.checkout.delivery');
					break;
				case '/formadepagamento':
					$state.go('root.checkout.payment');
					break;
			}
		}

  }

})();
