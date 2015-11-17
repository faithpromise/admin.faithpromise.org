(function(module) {
    'use strict';

    module.factory('requestsService', service);

    service.$inject = ['$http'];

    function service($http) {

        return {

            all: function() {
                return $http.get('/api/requests');
            }

        };

    }

})(angular.module('admin'));
