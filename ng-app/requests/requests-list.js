(function (module) {
    'use strict';

    module.directive('requestsList', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-list.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    Controller.$inject = ['requestsService'];

    function Controller(requestsService) {

        var vm = this;

        init();

        function init() {
            requestsService.all().then(function(response) {
                vm.tickets = response.data.tickets;
            });
        }

    }

})(angular.module('admin'));