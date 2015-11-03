(function (module) {
    'use strict';

    module.directive('verifyEmail', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/auth/verify-email.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    Controller.$inject = ['$window', '$location', '$rootScope', '$http', '$stateParams', '$auth'];

    function Controller($window, $location, $rootScope, $http, $stateParams, $auth) {

        init();

        function init() {

            var data = {token: $stateParams.token};

            $http.get('/auth/verify-email', {params: data}).then(function (response) {

                $auth.setToken(response.data.token);
                $window.localStorage.user = JSON.stringify(response.data.user);
                $rootScope.user = response.data.user;
                $location.path('/');

            });

            // TODO: Handle error from server and redirect back to register route
            // TODO: Increase time and implement refresh

        }

    }

})(angular.module('admin'));