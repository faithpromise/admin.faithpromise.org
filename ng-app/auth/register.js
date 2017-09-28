(function (module) {
    'use strict';

    module.directive('register', directive);

    function directive() {
        return {
            templateUrl:      '/build/ng-app/auth/register.html',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {}
        };
    }

    Controller.$inject = ['$http'];

    function Controller($http) {

        var vm            = this;
        vm.email_username = null;
        vm.email_sent     = false;
        vm.send           = send;

        function send() {

            var data = { username: vm.email_username };

            $http.post('/auth/register', data)
                .success(function () {
                    vm.email_sent = true;
                })
                .error(function () {
                    alert('Error occurred')
                });

        }

    }

})(angular.module('admin'));