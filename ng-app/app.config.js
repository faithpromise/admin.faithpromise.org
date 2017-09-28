(function (module) {

    module.config(Config);
    module.run(Run);

    Config.$inject = ['$locationProvider', '$resourceProvider', '$httpProvider'];

    function Config($locationProvider, $resourceProvider, $httpProvider) {

        $locationProvider.html5Mode(true);

        $resourceProvider.defaults.stripTrailingSlashes = false;

        $httpProvider.interceptors.push('authInterceptor');

    }

    Run.$inject = ['$document', '$location', '$rootScope', '$cookies', 'jwtHelper', 'USER'];

    function Run($document, $location, $rootScope, $cookies, jwtHelper, USER) {

        // Add user to root scope if found in local storage
        $rootScope.user = USER;

        $rootScope.$on('$locationChangeStart', function (event, next, current) {

            var jwt              = $cookies.get('jwt'),
                logged_in        = jwt && !jwtHelper.isTokenExpired(jwt),
                account_complete = $rootScope.user !== null,
                is_logging_in    = $location.path() === '/login',
                is_registering   = $location.path() === '/register';

            // Redirect to login if not authenticated
            if (!logged_in && !is_logging_in) {
                $location.path('/login');
            }

            // Redirect to /register if authenticated, but account not complete
            if (logged_in && !account_complete && !is_registering) {
                $location.path('/register');
            }

            //Restrict login and register pages if already logged in and registered
            if ((logged_in && is_logging_in) || account_complete && is_registering) {
                $location.path('/home');
            }

        });

        $rootScope.$on('$stateChangeSuccess', function () {
            $document[0].body.scrollTop = $document[0].documentElement.scrollTop = 0;
        });

    }

})(angular.module('admin'));