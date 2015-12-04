module.exports = function (grunt) {

    var config = {};

    grunt.option('build_root', 'public/build');
    grunt.option('release_root', '_release');
    grunt.option('less', {
        root:            'less',
        src:             'less/admin.less',
        dest_dev:        'public/build/admin.dev.css',
        dest_production: 'public/build/admin.min.css'
    });
    grunt.option('js', {
        src:                 [
            'bower_components/angular-ui-bootstrap/src/position/position.js',
            'bower_components/angular-ui-bootstrap/src/dropdown/dropdown.js',
            'bower_components/angular-toastr/dist/angular-toastr.tpls.js',
            'ng-app/app.module.js',
            'ng-app/app.config.js',
            'ng-app/app.routes.js',
            'ng-app/**/*.routes.js',
            'ng-app/**/*.js'
        ],
        dest_dev:            'public/build/admin.dev.js',
        dest_production:     'public/build/admin.min.js',
        dest_production_tmp: 'public/build/admin.tmp.js'
    });
    grunt.option('ng', {
        root: 'ng-app',
        dest: 'public/build/ng-app'
    });
    grunt.option('fontello', {
        root: 'assets/fontello',
        src:  'assets/fontello/font/*.*',
        dest: 'public/build/fontello'
    });
    grunt.option('svg', {
        src:  'assets/svg/general/*.svg',
        dest: 'public/build/general.svg'
    });

    // Load NPM tasks
    require('load-grunt-tasks')(grunt);

    // Init
    grunt.initConfig(config);

    // Load tasks
    grunt.loadTasks('grunt_tasks');

};
