(function () {
	'use strict';

	angular.module ('app')


	.controller ('PanelStoreController', PanelStoreController);


	function PanelStoreController ($state, $http, $scope){
		var vm = this;

		_init();
		
		///////// Functions /////////
		function _init () {
			checkLoja();
		}

		function checkLoja(){
			var free = false;
			$http.get('system/public/store/checkStore')
			.then(function(response){
				switch($state.current.url){
					case '/editar':
						free = false;
						break;
					case '/minhaloja':
						free = true;
						break;
					default:
						free = true;
						break;
				}
				if(free){
					if(response.data.success){
						$state.go('root.panel.store.view');
					}
					else{
						$state.go('root.panel.store.create')
					}
				}
			});
		};


	}
})();
