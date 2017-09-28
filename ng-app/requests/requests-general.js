(function (module) {
    'use strict';

    module.directive('requestsGeneral', directive);

    function directive() {
        return {
            templateUrl:      '/build/ng-app/requests/requests-general.html?v=1',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {
                type:               '@',
                title:              '@',
                subtitle:           '@',
                header:             '@',
                subjectLabel:       '@',
                subjectPlaceholder: '@',
                dateLabel:          '@',
                descriptionLabel:   '@',
                image:              '@',
                showCampus:         '@'
            }
        };
    }

    Controller.$inject = ['$scope', '$sce', '$state', 'requestsService', 'campusesService', 'toastr'];

    function Controller($scope, $sce, $state, requestsService, campusesService, Notification) {

        var vm         = this;
        vm.ticket      = { type: vm.type, title: vm.title };
        vm.submit      = submit;
        vm.hero_header = $sce.trustAsHtml(this.header);

        init();

        function init() {
            campusesService.all().then(function (data) {
                vm.campuses = data.data;
            });
        }

        function submit() {

            var data = { ticket: vm.ticket };

            vm.is_sending = true;

            requestsService.save(data).success(function () {
                Notification.success('Request sent. Thank you!');
                $state.go('main.requests_new');
            }).error(function () {
                Notification.error('An error occurred. Your request could not be sent.');
                vm.is_sending = false;
            });
        }

    }

})(angular.module('admin'));
