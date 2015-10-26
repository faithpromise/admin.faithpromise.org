(function(module) {

    module.config(Config);

    Config.$inject = ['$locationProvider', '$resourceProvider', '$httpProvider', '$authProvider', 'config'];

    function Config($locationProvider, $resourceProvider, $httpProvider, $authProvider, config) {

        $locationProvider.html5Mode(true);

        $resourceProvider.defaults.stripTrailingSlashes = false;

        // Auth config
        $authProvider.loginUrl = '/login';
        $authProvider.tokenPrefix = 'fp_admin';

        $authProvider.oauth1({
            name: 'faithpromise',
            url: '/auth/request-token',
            authorizationEndpoint: 'https://fpctystn.staging.fellowshiponeapi.com/v1/PortalUser/Login',
            redirectUri: config.api_uri + '/auth/',
            popupOptions: { width: 600, height: 400 }
        });

        // Interceptors
        $httpProvider.interceptors.push('apiUrlInterceptor');

    }

    module.constant('config', {
        api_uri: 'http://api.192.168.10.10.xip.io/v1'
    });

})(angular.module('admin'));
