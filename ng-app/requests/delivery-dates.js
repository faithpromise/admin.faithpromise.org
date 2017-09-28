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
                dates: '=',
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
        vm.is_visible = is_visible;
        vm.show_divider = show_divider;

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

        function is_visible() {
            return vm.eventDate
                || has_dates();
        }

        function show_divider() {
            return vm.eventDate && has_dates()
        }

        function has_dates() {
            return (vm.dates.length > 1)
                || (vm.dates.length === 1 && vm.dates[0].slug !== vm.exclude);
        }

    }

})(angular.module('admin'), moment);