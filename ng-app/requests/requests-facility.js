(function (module) {
    'use strict';

    module.directive('requestsFacility', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-facility.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));
