module.exports = function (grunt) {

    var js_src = [
        'bower_components/angular-ui-bootstrap/src/position/position.js',
        'bower_components/angular-ui-bootstrap/src/dropdown/dropdown.js',
        'bower_components/angular-toastr/dist/angular-toastr.tpls.js',
        'ng-app/app.module.js',
        'ng-app/app.config.js',
        'ng-app/app.routes.js',
        'ng-app/**/*.routes.js',
        'ng-app/**/*.js'
    ];

    grunt.config('concat', {

        options: {
            separator: '\n;'
        },

        js_dev: {
            src: js_src,
            dest: 'public/build/admin.dev.js'
        }

    });

};
