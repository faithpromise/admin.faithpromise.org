(function (module, angular) {
    'use strict';

    module.directive('requestsGraphics', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-graphics.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    Controller.$inject = ['$scope'];

    function Controller($scope) {

        var vm = this;
        vm.subject = '';
        vm.event_date = null;
        vm.toggle_item = toggle_item;
        vm.has_items_selected = has_items_selected;
        vm.submit = submit;
        vm.helper_dates = [];
        vm.items = {
            invite_card: {title: 'Invite Card'},
            flyer: {title: 'Flyer'},
            seat_card: {title: 'Seatback Card'},
            slide: {title: 'Slide In Service'},
            t_shirt: {title: 'T-Shirt'},
            sign: {title: 'Sign'},
            logo: {title: 'Logo'},
            website_update: {title: 'Website Update'},
            other: {title: 'Other'}
        };

        function submit() {
            var data = {
                requests: gather_requests()
            };

            console.log(data);
        }

        function gather_requests() {
            var result = [];

            angular.forEach(vm.items, function(item, key) {
                if (item.selected) {
                    item.type = key;
                    item.subject = vm.subject;
                    item.description = 'Event is happening on ' + vm.event_date;
                    result.push(item);
                }
            });

            return result;
        }

        function toggle_item(item) {
            item.selected = !item.selected;
        }

        function has_items_selected() {
            var result = false;
            angular.forEach(vm.items, function (item) {
                if (item.selected) {
                    return result = true;
                }
            });
            return result;
        }

        function update_helper_dates() {
            var helper_dates = [];
            angular.forEach(vm.items, function (value) {
                if (value.deliver_by && value.selected) {
                    helper_dates.push({
                        slug: value.slug,
                        title: value.title,
                        deliver_by: value.deliver_by
                    });
                }
            });
            vm.helper_dates = helper_dates;
        }

        $scope.$watch('vm.items', update_helper_dates, true);

    }

})(angular.module('admin'), angular);