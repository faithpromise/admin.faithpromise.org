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

    Controller.$inject = ['$scope', '$state', 'requestsService', 'toastr', 'USER'];

    function Controller($scope, $state, requestsService, Notification, USER) {

        var vm = this;
        vm.user = USER;
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
            create_item('graphics_invite_card', 'Invite Card', 'What should your invite card say?');
            create_item('graphics_flyer', 'Flyer', 'What should it say?');
            create_item('graphics_seat_card', 'Seatback Card', 'Briefly describe the purpose of your card.');
            create_item('graphics_slide', 'Slide In Service', 'What should your slide say?');
            create_item('graphics_apparel', 'T-Shirt/Apparel', 'Briefly describe your t-shirt idea.');
            create_item('graphics_sign', 'Signage', 'What should your sign say?'); // TODO: Should say, "When do you need it installed?"
            create_item('graphics_website', 'Website Promo', 'What needs to be added or changed on the website?');
            create_item('graphics_other', 'Other Project', 'Please describe your project?');
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

            vm.is_sending = true;

            requestsService.batch_save(data).success(function () {
                Notification.success('Request sent. Thank you!');
                $state.go('main.requests_new');
            }).error(function() {
                Notification.error('An error occurred. Your request could not be sent.');
                vm.is_sending = false;
            });
        }

        function gather_requests() {
            var result = [];

            angular.forEach(vm.items, function (item, key) {
                if (item.meta.selected) {
                    item.meta.type = key;
                    item.subject = vm.subject + ' [' + item.title + ']';
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
            angular.forEach(vm.items, function (value, key) {
                if (value.deliver_by && value.meta.selected) {
                    helper_dates.push({
                        slug: key,
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