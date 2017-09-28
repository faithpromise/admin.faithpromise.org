module.exports = function (grunt) {

    var js   = grunt.option('js'),
        less = grunt.option('less');

    grunt.config('autoprefixer', {

        options:    {
            browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
        },
        dev:        {
            src: less.dest_dev
        },
        production: {
            src: less.dest_production
        }

    });

};
