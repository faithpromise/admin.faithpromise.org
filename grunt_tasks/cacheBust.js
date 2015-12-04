module.exports = function (grunt) {

    var release_root = grunt.option('release_root');

    grunt.config('cacheBust', {

        options: {
            baseDir: release_root + '/public',
            rename:  false
        },

        production: {
            files: [
                {
                    src: [
                        release_root + '/resources/views//*.php',
                        release_root + '/resources/views/layouts/**/*.php'
                    ]
                }
            ]
        }

    });

};
