(function (module) {
    'use strict';

    module.directive('requestsNew', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-new.html',
            restrict: 'E',
            controller: Controller,
            controllerAs: 'vm',
            bindToController: true,
            scope: {}
        };
    }

    function Controller() {

        var vm = this;

        vm.cards = [
            {
                type: 'tech-support',
                title: 'Tech Support',
                description: 'Computer, email, printing, and Internet issues.',
                image: '',
                staffer: 'joe-filipowicz'
            },
            {
                type: 'worship-tech',
                title: 'Worship Tech',
                description: 'Mics, projectors, lights, or other worship equipment issues.',
                image: '',
                staffer: 'emily-carringer'
            },
            {
                type: 'graphics',
                title: 'Graphics',
                description: 'Flyers, brochures, invite cards, t-shirts, logos, slides, etc.',
                image: '',
                staffer: 'heather-burson'
            },
            {
                type: 'video',
                title: 'Video',
                description: 'Video shoots for event promotion, interviews, short films, etc.',
                image: '',
                staffer: 'adam-chapman'
            },
            {
                type: 'photo',
                title: 'Photo',
                description: 'Request a photographer for your event or project.',
                image: '',
                staffer: 'kyle-gilbert'
            },
            {
                type: 'website',
                title: 'Website',
                description: 'Request an update or report an issue with our website.',
                image: '',
                staffer: 'brad-roberts'
            },
            {
                type: 'resources',
                title: 'FP Resources',
                description: 'Promote a t-shirt, CD, book, or other item for sale.',
                image: '',
                staffer: 'mallory-ellis'
            },
            {
                type: 'facility',
                title: 'Facility',
                description: 'Repairs and replacements for common items.',
                image: '',
                staffer: 'marti-willen'
            },
            {
                type: 'construction',
                title: 'Construction',
                description: 'Renovation, remodeling, and building projects.',
                image: '',
                staffer: 'sid-spiva'
            }
        ];

        init();

        function init() {

        }

    }

})(angular.module('admin'));