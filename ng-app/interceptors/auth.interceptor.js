(function (module) {

    module.factory('authInterceptor', factory);

    factory.$inject = ['$q', '$cookies'];

    function factory($q, $cookies) {

        return {
            request:  request,
            response: response
        };

        function request(requestConfig) {

            var jwt = $cookies.get('jwt');

            if (/\.html$/.test(requestConfig.url)) {
                return requestConfig;
            }

            requestConfig.headers = requestConfig.headers || {};

            if (jwt) {
                requestConfig.headers.Authorization = 'Bearer ' + jwt;
            }

            return requestConfig;
        }

        function response(response) {

            if (response.status === 401) {
                // TODO: Handle case where user is not authenticated
            }

            return response || $q.when(response);

        }

    }

}(angular.module('admin')));