(function(module) {

    module.config(Config);

    Config.$inject = ['$stateProvider', '$urlRouterProvider'];

    function Config($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('/requests/new');

        $stateProvider
            .state('main', {
                abstract: true,
                url: '/',
                templateUrl: '/build/ng-app/common/main-layout.html'
            })
            .state('main.home', {
                url: '^/home',
                template: 'home'
            });

        // Authentication
        $stateProvider
            .state('auth', {
                abstract: true,
                url: '/auth',
                templateUrl: '/build/ng-app/common/auth-layout.html'
            })
            .state('auth.login', {
                url: '^/login',
                template: '<login></login>'
            })
            .state('auth.register', {
                url: '^/register',
                template: '<register></register>'
            })
            .state('auth.verify-email', {
                url: '^/verify-email/:token',
                template: '<verify-email></verify-email>'
            });

        // Support Requests
        $stateProvider
            .state('main.requests', {
                url: '^/requests',
                template: '<requests-list></requests-list>'
            })
            .state('main.requests_new', {
                url: '^/requests/new',
                template: '<requests-new></requests-new>'
            })
            .state('main.requests_graphics', {
                url: '^/requests/graphics',
                template: '<requests-graphics></requests-graphics>'
            })
            .state('main.requests_photo', {
                url: '^/requests/photo',
                template: '<requests-photo></requests-photo>'
            })
            .state('main.requests_website', {
                url: '^/requests/website',
                template: '<requests-website></requests-website>'
            });

    }

})(angular.module('admin'));