(function(module) {

    module.config(Config);
    module.run(Run);

    Config.$inject = ['$locationProvider', '$resourceProvider', '$authProvider'];

    function Config($locationProvider, $resourceProvider, $authProvider) {

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

    }

    Run.$inject = ['$window', '$location', '$rootScope', '$auth'];

    function Run($window, $location, $rootScope, $auth) {

        // Add user to root scope if found in local storage
        if ($window.localStorage.user) {
            $rootScope.user = JSON.parse($window.localStorage.user);
        }

        $rootScope.$on('$locationChangeStart', function(event, next, current) {

            var user = $window.localStorage.user ? JSON.parse($window.localStorage.user) : null;

            var logged_in = $auth.isAuthenticated(),
                account_complete = user !== null,
                is_logging_in = $location.path() === '/login',
                is_registering = ($location.path() === '/register') || ($location.path().indexOf('/verify-email') >= 0);

            // Redirect to login if not authenticated
            if (!logged_in && !is_logging_in) {
                $location.path('/login');
            }

            // Redirect to /register if authenticated, but account not complete
            if (logged_in && !account_complete && !is_registering) {
                $location.path('/register');
            }

        });

    }

})(angular.module('admin'));
