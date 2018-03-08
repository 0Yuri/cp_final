(function() {
  	'use strict';

  	function uploadService ($http, $q){

      return ({
        upload: upload
      });

      function upload(file){
        var upl = $http({
          method: 'POST',
          url: 'system/public/upload', // /api/upload
          data: {
            upload: file
          },
          transformRequest: function(data, headersGetter) {
            var formData = new FormData();
            angular.forEach(data, function(value, key) {
              formData.append(key, value);
            });

            var headers = headersGetter();
            delete headers['Content-Type'];

            return formData;
          }
        });

        return upl.then(handleSuccess, handleError);
      }

      function handleError(response, data) {
        if (!angular.isObject(response.data) ||!response.data.message) {
          return ($q.reject("An unknown error occurred."));
        }

        return ($q.reject(response.data.message));
      }

      function handleSuccess(response) {
        return (response);
      }
  	}

    angular.module('app').service('uploadService', uploadService);

})();
