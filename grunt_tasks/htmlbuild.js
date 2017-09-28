module.exports = function (grunt) {

    var js           = grunt.option('js'),
        less         = grunt.option('less'),
        release_root = grunt.option('release_root');

    grunt.config('htmlbuild', {

        production: {
            src:     [
                release_root + '/resources/views//*.php',
                release_root + '/resources/views/layouts/**/*.php'
            ],
            options: {
                relative: false,
                replace:  true,
                prefix:   '/',
                scripts:  {
                    admin: {
                        cwd:   release_root + '/public',
                        files: 'build/admin.min.js'
                    }
                },
                styles:   {
                    admin: {
                        cwd:   release_root + '/public',
                        files: 'build/admin.min.css'
                    }
                }
            }
        }

    });

};
