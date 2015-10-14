(function(module) {

    module.config(Config);

    Config.$inject = ['$routeProvider'];

    function Config(routeProvider) {

        routeProvider.when('/requests', {
            template: '<requests-list></requests-list>'
        });

        routeProvider.when('/requests/new', {
            template: '<requests-new></requests-new>'
        });

        routeProvider.when('/requests/new/graphics', {
            template: '<requests-graphics></requests-graphics>'
        });

    }

})(angular.module('admin'));