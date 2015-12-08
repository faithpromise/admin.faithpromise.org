(function (module) {
    'use strict';

    module.directive('requestsPhoto', directive);

    function directive() {
        return {
            templateUrl:      '/build/ng-app/requests/requests-photo.html',
            restrict:         'E',
            controller:       Controller,
            controllerAs:     'vm',
            bindToController: true,
            scope:            {}
        };
    }

    Controller.$inject = ['$scope', 'requestsService'];

    function Controller($scope, requestsService) {

        var vm    = this;
        vm.ticket = { type: 'graphics_photo' };
        vm.submit = submit;

        function submit() {

            var data = { ticket: vm.ticket };

            requestsService.save(data).then(function (response) {
                console.log('requests sent', response, data);
            });
        }

        function update_subject(newValue) {
            vm.ticket.subject = 'Photographer for ' + newValue;
        }

        $scope.$watch('vm.raw_subject', update_subject);

    }

})(angular.module('admin'));
