(function () {
    'use strict';

    function testService ($http, $state) {
      return{
        get:function(){
          return $http.get('system/public/imagens');
        },
        post:function(data){
          return $http.post('system/public/upload', data, {
            transformRequest: angular.identity,
            headers: {'Content-Type':undefined}
          });
        },
        delete: function(id){
          return true;
        }
      }
  	}

    angular.module('app').service ('testService', testService);
})();
