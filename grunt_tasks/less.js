module.exports = function (grunt) {

    var less_src = 'less/admin.less';

    grunt.config('less', {

        dev: {
            files: [
                {
                    src: less_src,
                    dest: 'public/build/admin.dev.css'
                }
            ],
            options: {
                compress: false
            }
        },

        production: {
            files: [
                {
                    src: less_src,
                    dest: 'public/build/admin.min.css'
                }
            ],
            options: {
                compress: true
            }
        }

    });

};
