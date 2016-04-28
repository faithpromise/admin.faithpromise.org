(function (module) {
    'use strict';

    module.directive('requestsNew', directive);

    function directive() {
        return {
            templateUrl: '/build/ng-app/requests/requests-new.html?v=1',
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
                staffer: 'joe-filipowicz',
                submit_text: 'helpdesk@faithpromise.org',
                submit_link: 'mailto:helpdesk@faithpromise.org'
            },
            {
                type: 'worship-tech',
                title: 'Worship Tech',
                description: 'Mics, projectors, lights, or other worship equipment issues.',
                image: '',
                staffer: 'emily-carringer',
                submit_link: 'http://www.faithpromiseweb.com/request/tech-maintenance-request/'
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
                staffer: 'adam-chapman',
                submit_link: 'http://www.faithpromiseweb.com/request/video-request-2/'
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
                title: 'Website Change',
                description: 'Request an update or report an issue with our website.',
                image: '',
                staffer: 'brad-roberts'
            },
            {
                type: 'resources',
                title: 'FP Resources',
                description: 'Promote a t-shirt, CD, book, or other item for sale.',
                image: '',
                staffer: 'mallory-ellis',
                submit_link: 'http://www.faithpromiseweb.com/request/fpresources-sales-request/'
            },
            {
                type: 'facility',
                title: 'Facility',
                description: 'From repairs and replacements to construction. We\'ve got you covered.',
                image: '',
                staffer: 'marti-willen'
            }
        ];

        init();

        function init() {

        }

    }

})(angular.module('admin'));