module.exports = function (grunt) {

    var config = {};

    // Load NPM tasks
    require('load-grunt-tasks')(grunt);

    // Init
    grunt.initConfig(config);

    // Load tasks
    grunt.loadTasks('grunt_tasks');

};
