(function () {
    'use strict';

    function userService ($q, $http, $state) {
        var service = this;

        var userCache = null;

        service.login = login;
        service.onlyUsers = onlyUsers;
        service.cache = cache;

        _init();

        ///////// Functions /////////

        function _init() {
            // TODO
        }

        /**
         * @param   {Object} input User's email and password
         * @returns {Promise}
         */
        function login (input) {
            var deferred = $q.defer();
            $http.post('system/public/user/login', input)
            .then(function(response) {
              if (response.data.success) {
                  console.log("OK");
                    userCache = response.data;
                    deferred.resolve(true);
              }else{
                    userCache = null;
                    deferred.reject(response.data.error);
              }
    			 }).catch(function(error) {
                    deferred.reject('Erro!');
            });
                return deferred.promise;
            }

        /**
         *
         */
        function onlyUsers () {
          $http.get('system/public/user/session')
          .then(function success(response){
            if(!response.data.success){
              $state.go('root.home');
            }
          }, function error(response){
            console.log('HTTP ERROR: '+response.status);
          });
        }


        /**
         *
         * @param {String} child Reference to user data required
         */
        function cache (child) {
            var deferred = $q.defer();

            // If data is not cached
            if(!userCache) {
                $http.get('system/public/user/logged_user')
          			.then(
          				function success(response){
          					if(response.data.success) {
                                userCache = response.data;
                                deferred.resolve(userCache[child] || userCache);
                            }
          				}, function error(error){
                            deferred.reject(error);
          				}
          			);
            }
            else {
                deferred.resolve(userCache[child] || userCache);
            }

            return deferred.promise;
        }
  	}

    userService.$inject =  ['$q', '$http', '$state'];
    angular.module('app').service('userService', userService);
})();
