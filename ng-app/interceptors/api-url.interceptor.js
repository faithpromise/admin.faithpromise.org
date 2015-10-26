(function(module) {

    module.factory('apiUrlInterceptor', factory);

    factory.$inject = ['config'];

    function factory(config) {

        return {
            request: request
        };

        function request(requestConfig) {
            var url = requestConfig.url;

            // If we're requesting a template
            if (url.indexOf('.html') > -1) {
                return requestConfig;
            }

            // Otherwise, prepend base API url
            requestConfig.url = config.api_uri + url;

            return requestConfig;
        }

    }

}(angular.module('admin')));