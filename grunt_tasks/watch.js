module.exports = function (grunt) {

    var less_root = grunt.option('less').root;

    grunt.config('watch', {

        css: {
            files: [less_root + '/**/*.less'],
            tasks: ['css_dev']
        }

    });

};
