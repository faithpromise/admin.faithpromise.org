(function(module) {

    module.config(Config);

    Config.$inject = ['$stateProvider', '$urlRouterProvider'];

    function Config($stateProvider, $urlRouterProvider) {

        $stateProvider.state('home', {
            url: '/',
            template: 'home'
        });

        $urlRouterProvider.otherwise('/');

    }

})(angular.module('admin'));