(function(module) {
    'use strict';

    module.factory('requestsService', service);

    service.$inject = ['$http'];

    function service($http) {

        return {

            all: function() {
                return $http.get('/api/requests');
            },

            batch_save: function(data) {
                return $http.post('/api/requests/batch', data);
            }
        };

    }

})(angular.module('admin'));
