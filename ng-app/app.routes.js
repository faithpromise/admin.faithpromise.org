(function(module) {

    module.config(Config);

    Config.$inject = ['$stateProvider', '$urlRouterProvider'];

    function Config($stateProvider, $urlRouterProvider) {

        $stateProvider.state('home', {
            url: '/',
            template: 'home'
        });

        $stateProvider.state('login', {
            url: '/login',
            template: '<login></login>'
        });

        $stateProvider.state('register', {
            url: '/register',
            template: '<register></register>'
        });

        $stateProvider.state('verify-email', {
            url: '/verify-email',
            template: '<verify-email></verify-email>'
        });

        $urlRouterProvider.otherwise('/');

    }

})(angular.module('admin'));