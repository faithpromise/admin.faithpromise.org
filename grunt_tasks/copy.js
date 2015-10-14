module.exports = function (grunt) {

    grunt.config('copy', {

        fontello: {
            expand: true,
            flatten: true,
            src: 'assets/fontello/font/*.*',
            dest: 'public/build/fontello'
        }

    });

};
