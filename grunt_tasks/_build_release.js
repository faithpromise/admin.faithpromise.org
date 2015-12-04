module.exports = function (grunt) {

    grunt.registerTask('_build_release', [

        // clean
        'clean:build',
        'clean:release',

        // js
        'concat:js_production',
        'removelogging:main',
        'uglify:main',

        // css
        'copy:fontello',
        'replace:fontello',
        'less:production',

        // files
        'copy:ng_templates',
        'svgstore:default',

        // copy release files
        'copy:release',

        // replacements (in release files only)
        'htmlbuild:production'

    ]);

};
