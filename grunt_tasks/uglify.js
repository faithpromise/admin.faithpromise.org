module.exports = function (grunt) {

    var js = grunt.option('js');

    grunt.config('uglify', {

        main: {
            files: [
                {
                    src:  js.dest_production_tmp,
                    dest: js.dest_production
                }

            ]
        }

    });

};
