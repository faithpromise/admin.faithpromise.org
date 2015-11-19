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

    Controller.$inject = ['$scope', '$rootScope', 'requestsService'];

    function Controller($scope, $rootScope, requestsService) {

        var vm = this;
        vm.user = $rootScope.user;
        vm.subject = '';
        vm.event_date = null;
        vm.toggle_item = toggle_item;
        vm.has_items_selected = has_items_selected;
        vm.submit = submit;
        vm.helper_dates = [];
        vm.items = {};

        init();

        function init() {
            create_items();
        }

        function create_items() {
            create_item('invite_card', 'Invite Card', 'What should your invite card say?');
            create_item('flyer', 'Flyer', 'What should it say?');
            create_item('seat_card', 'Seatback Card', 'Briefly describe the purpose of your card.');
            create_item('slide', 'Slide In Service', 'What should your slide say?');
            create_item('t_shirt', 'T-Shirt', 'Briefly describe your t-shirt idea.');
            create_item('sign', 'Sign', 'What should your sign say?');
            create_item('website_update', 'Website Update', 'What needs to be added or changed on the website?');
            create_item('other', 'Other Project', 'Please describe your project?');
        }

        function create_item(ident, title, description_label) {
            vm.items[ident] = {
                title: title,
                meta: {
                    description_label: description_label
                }

            };
        }

        function submit() {
            var data = {
                requests: gather_requests()
            };

            requestsService.batch_save(data).then(function (response) {
                console.log('requests sent', response, data);
            });
        }

        function gather_requests() {
            var result = [];

            angular.forEach(vm.items, function (item, key) {
                if (item.meta.selected) {
                    item.meta.type = key;
                    item.subject = '(' + item.title + ') ' + vm.subject;
                    result.push(item);
                }
            });

            return result;
        }

        function toggle_item(item) {
            item.meta.selected = !item.meta.selected;
        }

        function has_items_selected() {
            var result = false;
            angular.forEach(vm.items, function (item) {
                if (item.meta.selected) {
                    return result = true;
                }
            });
            return result;
        }

        function update_helper_dates() {
            var helper_dates = [];
            angular.forEach(vm.items, function (value) {
                if (value.deliver_by && value.meta.selected) {
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