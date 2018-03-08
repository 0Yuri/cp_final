(function () {
	'use strict';

	angular.module ('app')

	.directive("fileinput", [function(){
		return {
			scope: {
				fileinput: "=",
				filepreview: "="
			},
			link: function(scope, element, attributes) {
				element.bind("change", function(changeEvent){
					scope.fileinput = changeEvent.target.files[0];
					var reader = new FileReader();
					reader.onload = function(loadEvent){
						scope.$apply(function(){
							scope.filepreview = loadEvent.target.result;
						});
					}
					reader.readAsDataURL(scope.fileinput);
				});
			}
		}
	}])

	.directive('fileModel', ['$parse', function($parse){
		return{
			restrict: 'A',
			link: function(scope, element, attrs){
				var model = $parse(attrs.fileModel);
				var modelSetter = model.assign;

				element.bind('change', function(){
					scope.$apply(function(){
						modelSetter(scope, element[0].files[0]);
					});
				});
			}
		};
	}])

	.directive ('modal', modal)

	function modal ($pathTo) {
		return {
			restrict: 'AE',
			scope: {
				id: '@modalId',
				type: '@modalType',
				title: '@modalTitle',
			},
			transclude: true,
			templateUrl: $pathTo.directivesFolder+'modal.html'
		};
	}
})();
