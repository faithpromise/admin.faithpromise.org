module.exports = function (grunt) {

    var ng_root = grunt.option('ng').root;

    grunt.config('copy', {

        ng_templates: {
            expand: true,
            cwd: ng_root,
            src: '**/*.html',
            dest: 'public/build/ng-app'
        },

        fontello: {
            expand: true,
            flatten: true,
            src: 'assets/fontello/font/*.*',
            dest: 'public/build/fontello'
        }

    });

};
