module.exports = function (grunt) {

    var less_root = grunt.option('less').root;
    var ng_root = grunt.option('ng').root;

    grunt.config('watch', {

        css: {
            files: [less_root + '/**/*.less'],
            tasks: ['css_dev']
        },

        ng: {
            files: [ng_root + '/**/*.js'],
            tasks: ['concat:js_dev']
        },

        ng_templates: {
            files: [ng_root + '/**/*.html'],
            tasks: ['copy:ng_templates']
        }

    });

};
