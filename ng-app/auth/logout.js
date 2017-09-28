(function (module) {
    'use strict';

    module.directive('logout', directive);

    function directive() {
        return {
            template:         '',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {}
        };
    }

    Controller.$inject = ['$location', '$cookies'];

    function Controller($location, $cookies) {

        $cookies.remove('jwt');
        $cookies.remove('user');
        $location.path('/login');

    }

})(angular.module('admin'));