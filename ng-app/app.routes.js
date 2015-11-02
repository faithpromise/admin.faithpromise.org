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
            template: 'register yo self'
        });

        $urlRouterProvider.otherwise('/');

    }

})(angular.module('admin'));