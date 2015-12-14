module.exports = function (grunt) {

    grunt.registerTask('css_dev', [
        'copy:fontello',
        'replace:fontello',
        'less:dev',
        'autoprefixer:dev'
    ]);

};
