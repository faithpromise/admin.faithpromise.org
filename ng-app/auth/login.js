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

    Controller.$inject = ['$auth', '$window', '$rootScope'];

    function Controller($auth, $window, $rootScope) {

        var vm = this;

        vm.login = login;

        function login() {

            $auth.authenticate('faithpromise').then(function(response) {

                $window.localStorage.user = JSON.stringify(response.data.user);
                $rootScope.user = response.data.user;

            }).catch(function(response) {

                alert('An error occurred. Check console');
                console.log('error', response);

            });

        }

    }

})(angular.module('admin'));