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
        vm.items = {
            invite_card: {title: 'Invite Card', description_label: 'What should your invite card say?'},
            flyer: {title: 'Flyer', description_label: 'What should it say?'},
            seat_card: {title: 'Seatback Card', description_label: 'Briefly describe the purpose of your card?'},
            slide: {title: 'Slide In Service', description_label: 'What should your slide say?'},
            t_shirt: {title: 'T-Shirt', description_label: 'Briefly describe your t-shirt idea.'},
            sign: {title: 'Sign', description_label: 'What should your sign say?'},
            website_update: {title: 'Website Update', description_label: 'What needs to be added or changed on the website?'},
            other: {title: 'Other Project', description_label: 'Please describe your project?'}
        };

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
                if (item.selected) {
                    item.type = key;
                    item.subject = vm.subject;
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