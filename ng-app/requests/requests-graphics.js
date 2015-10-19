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
        vm.toggle_item = toggle_item;
        vm.is_item_selected = is_item_selected;
        vm.has_items_selected = has_items_selected;
        vm.set_date = set_date;

        vm.items = [
            {slug: 'invite_card', title: 'Invite Card'},
            {slug: 'flyer', title: 'Flyer'},
            {slug: 't_shirt', title: 'T-Shirt'},
            {slug: 'sign', title: 'Sign'},
            {slug: 'logo', title: 'Logo'},
            {slug: 'other', title: 'Other'}
        ];

        vm.selected_items = {};
        vm.num_items_selected = 0;
        vm.helper_dates = [];

        function toggle_item(item) {

            if (!vm.selected_items.hasOwnProperty(item.slug)) {
                vm.selected_items[item.slug] = {
                    active: true,
                    slug: item.slug,
                    title: item.title
                };
            } else {
                vm.selected_items[item.slug].active = !vm.selected_items[item.slug].active;
            }

        }

        function is_item_selected(slug) {
            return vm.selected_items.hasOwnProperty(slug) && vm.selected_items[slug].active;
        }

        function has_items_selected() {
            var i;
            for (i = 0; i < vm.items.length; i++) {
                if (is_item_selected(vm.items[i].slug)) {
                    return true;
                }
            }
            return false;
        }

        function set_date(date_string) {
            vm.selected_items.flyer.deliver_by = new Date(date_string);
        }

        function update_helper_dates() {
            var helper_dates = [];
            angular.forEach(vm.selected_items, function(value) {
                if (value.deliver_by && value.active) {
                    helper_dates.push({
                        slug: value.slug,
                        title: value.title,
                        deliver_by: value.deliver_by
                    });
                }
            });
            vm.helper_dates = helper_dates;
        }

        $scope.$watch('vm.selected_items', update_helper_dates, true);

    }

})(angular.module('admin'), angular);