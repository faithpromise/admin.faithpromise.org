(function(module) {

    module.constant('config', {
        // TODO: Make this dynamic
        api_uri: 'http://api.faithpromise.192.168.10.10.xip.io/v1'
    });
    module.config(Config);
    module.run(Run);

    Config.$inject = ['$locationProvider', '$resourceProvider', '$httpProvider', '$authProvider'];

    function Config($locationProvider, $resourceProvider, $httpProvider, $authProvider) {

        $locationProvider.html5Mode(true);

        $resourceProvider.defaults.stripTrailingSlashes = false;

        // Auth config
        $authProvider.loginUrl = '/login';
        $authProvider.tokenPrefix = '';
        $authProvider.oauth1({
            name: 'faithpromise',
            url: '/auth/fellowshipone',
            authorizationEndpoint: 'https://fpctystn.staging.fellowshiponeapi.com/v1/PortalUser/Login',
            redirectUri: null,
            popupOptions: { width: 600, height: 400 }
        });

        // Interceptors
        $httpProvider.interceptors.push('apiUrlInterceptor');

    }

    Run.$inject = ['$window', '$location', '$rootScope', '$auth'];

    function Run($window, $location, $rootScope, $auth) {

        // Add user to root scope if found in local storage
        if ($window.localStorage.user) {
            $rootScope.user = JSON.parse($window.localStorage.user);
        }

        $rootScope.$on('$locationChangeStart', function(event, next, current) {

            var logged_in = $auth.isAuthenticated() && $window.localStorage.user,
                is_logging_in = $location.path() === '/login',
                is_registering = ($location.path() === '/register') || ($location.path() === '/verify-email');

            // Redirect to login if not authenticated
            if (!logged_in && !is_logging_in) {
                $location.path('/login');
            }

            // Redirect to /register if authenticated, but no user id
            if (!$window.localStorage.user.id && !is_registering) {
                $location.path('/register');
            }

        });

    }

})(angular.module('admin'));
