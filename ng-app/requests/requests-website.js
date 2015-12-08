(function (module) {
    'use strict';

    module.directive('requestsWebsite', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-website.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));
