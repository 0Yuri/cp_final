(function() {
  	'use strict';

  	function pathToPrivider (){
  		var base = Window.PUBLIC_FOLDER_BASE_LINK;
  		var paths = {};
  		return{
  			addPath: function(param){
  				var newPath =
  					((typeof param.parent === "undefined")?
  						base:
  						paths[param.parent]
  					)+param.folder+'/';
  				paths[param.name] = newPath;
  				return this;
  			},
  			$get: function(){
  				return paths
  			}
  		}
  	}

    angular.module ('app').provider ("$pathTo", pathToPrivider);
})();
