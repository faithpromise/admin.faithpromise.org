(function (module) {
    'use strict';

    module.directive('login', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/auth/login.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));