module.exports = function (grunt) {

    var config = {};

    grunt.option('less', {
        root: 'less',
        src: 'less/admin.less',
        dest_dev: 'public/build/admin.dev.css',
        dest_production: 'public/build/admin.min.css'
    });

    grunt.option('ng', {
        root: 'ng-app'
    });

    // Load NPM tasks
    require('load-grunt-tasks')(grunt);

    // Init
    grunt.initConfig(config);

    // Load tasks
    grunt.loadTasks('grunt_tasks');

};
