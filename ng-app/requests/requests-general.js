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
                type:             '@',
                title:            '@',
                header:           '@',
                subjectLabel:     '@',
                dateLabel:        '@',
                descriptionLabel: '@',
                image:            '@'
            }
        };
    }

    Controller.$inject = ['$scope', 'requestsService'];

    function Controller($scope, requestsService) {

        var vm    = this;
        vm.ticket = { type: vm.type };
        vm.submit = submit;

        function submit() {

            var data = { ticket: vm.ticket };

            requestsService.save(data).then(function (response) {
                console.log('requests sent', response, data);
            });
        }

        function update_subject(newValue) {
            vm.ticket.subject = newValue + ' [' + vm.title + ']';
            console.log('subject', vm.ticket.subject);
        }

        $scope.$watch('vm.raw_subject', update_subject);

    }

})(angular.module('admin'));
