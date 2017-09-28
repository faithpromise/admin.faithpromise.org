module.exports = function (grunt) {

    var fontello   = grunt.option('fontello'),
        build_root = grunt.option('build_root');

    grunt.config('replace', {

        fontello: {
            options: {
                patterns:  [
                    {
                        match:       '../font/',
                        replacement: '/build/fontello/'
                    },
                    {
                        match:       '[class^="icon-"]',
                        replacement: '.icon:before, [class^="icon-"]'
                    }
                ],
                usePrefix: false
            },
            files:   [
                {
                    expand:  false,
                    flatten: true,
                    src:     fontello.root + '/css/fontello.css',
                    dest:    build_root + '/fontello/fontello.css'
                }
            ]
        }

    });

};
