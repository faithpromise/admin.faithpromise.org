module.exports = function (grunt) {

    var js = grunt.option('js');

    grunt.config('concat', {

        options: {
            separator: '\n;'
        },

        js_dev: {
            src:  js.src,
            dest: js.dest_dev
        },

        js_production: {
            src:  js.src,
            dest: js.dest_production_tmp
        }

    });

};
