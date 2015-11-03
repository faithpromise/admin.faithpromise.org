(function (module) {
    'use strict';

    module.directive('login', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/auth/login.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    Controller.$inject = ['$window', '$location', '$rootScope', '$auth'];

    function Controller($window, $location, $rootScope, $auth) {

        var vm = this;

        vm.login = login;

        function login() {

            $auth.authenticate('faithpromise').then(function (response) {

                if (response.data.user) {
                    $window.localStorage.user = JSON.stringify(response.data.user);
                    $rootScope.user = response.data.user;
                }

                $location.path('/');

            }).catch(function (response) {

                alert('An error occurred. Check console');
                console.log('error', response);

            });

        }

    }

})(angular.module('admin'));