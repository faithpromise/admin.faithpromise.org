module.exports = function (grunt) {

    grunt.registerTask('build_dev', [
        'less:dev',
        'concat:js_dev'
    ]);

};
