(function () {
    'use strict';

    function fileUploadService ($http, $state) {
      this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);

        $http.post(uploadUrl, fd,{
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined}
        });
      }
  	}

    angular.module('app').service ('fileUploadService', fileUploadService);
})();
