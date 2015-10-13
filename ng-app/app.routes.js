(function(module) {

    module.config(Config);

    Config.$inject = ['$routeProvider'];

    function Config(routeProvider) {

        routeProvider.when('/', {
            template: 'home'
        });

        routeProvider.otherwise({
            template: 'no route'
        });

    }

})(angular.module('admin'));