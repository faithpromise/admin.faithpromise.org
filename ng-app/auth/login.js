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

    Controller.$inject = ['$auth'];

    function Controller($auth) {

        var vm = this;

        vm.login = login;

        function login() {

            $auth.authenticate('faithpromise').then(function(response) {

                // TODO: Set user in local storage?
                $window.localStorage.currentUser = JSON.stringify(response.data.user);

            }).catch(function(response) {

                console.log('error', response);

            });

        }

    }

})(angular.module('admin'));