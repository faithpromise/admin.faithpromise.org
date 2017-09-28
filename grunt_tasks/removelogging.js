module.exports = function (grunt) {

    var js = grunt.option('js');

    grunt.config('removelogging', {

        main: {
            src: js.dest_production_tmp
        }

    });

};
