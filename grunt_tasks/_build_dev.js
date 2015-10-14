module.exports = function (grunt) {

    grunt.registerTask('build_dev', [
        'css_dev',
        'concat:js_dev',
        'copy:ng_templates',
        'svgstore:default'
    ]);

};
