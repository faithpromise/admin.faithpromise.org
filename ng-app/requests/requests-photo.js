(function (module) {
    'use strict';

    module.directive('requestsPhoto', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-photo.html',
            restrict:    'E'
        };
    }

})(angular.module('admin'));
