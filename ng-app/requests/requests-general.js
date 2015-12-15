(function (module) {
    'use strict';

    module.directive('requestsGeneral', directive);

    function directive() {
        return {
            templateUrl:      '/build/ng-app/requests/requests-general.html',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {
                type:               '@',
                title:              '@',
                header:             '@',
                subjectLabel:       '@',
                subjectPlaceholder: '@',
                dateLabel:          '@',
                descriptionLabel:   '@',
                image:              '@'
            }
        };
    }

    Controller.$inject = ['$scope', '$state', 'requestsService', 'toastr'];

    function Controller($scope, $state, requestsService, Notification) {

        var vm    = this;
        vm.ticket = { type: vm.type };
        vm.submit = submit;

        function submit() {

            var data = { ticket: vm.ticket };

            vm.is_sending = true;

            requestsService.save(data).success(function () {
                Notification.success('Request sent. Thank you!');
                $state.go('main.requests_new');
            }).error(function() {
                Notification.error('An error occurred. Your request could not be sent.');
                vm.is_sending = false;
            });
        }

        function update_subject(newValue) {
            vm.ticket.subject = newValue + ' [' + vm.title + ']';
        }

        $scope.$watch('vm.raw_subject', update_subject);

    }

})(angular.module('admin'));
