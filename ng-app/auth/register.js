(function (module) {
    'use strict';

    module.directive('register', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/auth/register.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    Controller.$inject = ['$http'];

    function Controller($http) {

        var vm = this;
        vm.email = null;
        vm.send = send;

        function send() {

            var data = { email: vm.email };

            $http.get('/verify-email', data, function() {
                alert('email sent');
            });

        }

    }

})(angular.module('admin'));