module.exports = function (grunt) {

    grunt.config('replace', {

        fontello: {
            options: {
                patterns: [
                    {
                        match: '../font/',
                        replacement: '/build/fontello/'
                    },
                    {
                        match: '[class^="icon-"]',
                        replacement: '.icon:before, [class^="icon-"]'
                    }
                ],
                usePrefix: false
            },
            files: [
                {
                    expand: false,
                    flatten: true,
                    src: 'assets/fontello/css/fontello.css',
                    dest: 'public/build/fontello/fontello.css.tmp'
                }
            ]
        }

    });

};
