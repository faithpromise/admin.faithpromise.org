(function (module, moment) {
    'use strict';

    module.directive('deliveryDates', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/delivery-dates.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: {
                items: '=',
                exclude: '@',
                deliverBy: '=',
                eventDate: '='
            },
            scope: {}
        };
    }

    Controller.$inject = [];

    function Controller() {

        var vm = this;
        vm.set_date = set_date;
        vm.subtract_days_from_event_date = subtract_days_from_event_date;

        function set_date(d) {
            d = (typeof d) === 'object' ? d : subtract_days_from_event_date(d);
            vm.deliverBy = d;
        }

        function subtract_days_from_event_date(num_days) {
            if (vm.eventDate) {
                return moment(vm.eventDate).subtract(num_days, 'days').toDate();
            }
            return null;
        }

    }

})(angular.module('admin'), moment);