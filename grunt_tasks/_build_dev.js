module.exports = function (grunt) {

    grunt.registerTask('build_dev', [

        // js
        'concat:js_dev',

        // css
        'css_dev',

        // files
        'copy:ng_templates',
        'svgstore:default'

    ]);

};
