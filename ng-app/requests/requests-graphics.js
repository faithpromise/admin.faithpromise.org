(function (module) {
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

    Controller.$inject = [];

    function Controller() {

        var vm = this;
        vm.toggle_item = toggle_item;
        vm.is_item_selected = is_item_selected;

        vm.items = [
            {slug: 'invite_card', title: 'Invite Card'},
            {slug: 'flyer', title: 'Flyer'},
            {slug: 't_shirt', title: 'T-Shirt'},
            {slug: 'sign', title: 'Sign'},
            {slug: 'logo', title: 'Logo'},
            {slug: 'other', title: 'Other'}
        ];

        vm.selected_items = {};

        init();

        function toggle_item(item) {

            if (is_item_selected(item.slug)) {
                delete vm.selected_items[item.slug];
            } else {
                vm.selected_items[item.slug] = { active: true };
            }
        }

        function is_item_selected(slug) {
            var result = vm.selected_items.hasOwnProperty(slug) && vm.selected_items[slug].active;
            return result;
        }

        function init() {

        }

    }

})(angular.module('admin'));