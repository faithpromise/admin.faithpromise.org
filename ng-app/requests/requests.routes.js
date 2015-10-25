(function (module) {

    module.config(Config);

    Config.$inject = ['$stateProvider'];

    function Config($stateProvider) {

        $stateProvider
            .state('requests', {
                url: '/requests',
                template: '<requests-list></requests-list>'
            })
            .state('requests_new', {
                url: '/requests/new',
                template: '<requests-new></requests-new>'
            })
            .state('requests_new_graphics', {
                url: '/requests/new/graphics',
                template: '<requests-graphics></requests-graphics>'
            });

    }

})(angular.module('admin'));