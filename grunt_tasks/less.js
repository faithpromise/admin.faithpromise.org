module.exports = function (grunt) {

    var less = grunt.option('less');

    grunt.config('less', {

        dev: {
            files: [
                {
                    src: less.src,
                    dest: less.dest_dev
                }
            ],
            options: {
                compress: false
            }
        },

        production: {
            files: [
                {
                    src: less.src,
                    dest: less.dest_production
                }
            ],
            options: {
                compress: true
            }
        }

    });

};
