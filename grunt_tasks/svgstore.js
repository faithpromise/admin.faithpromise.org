module.exports = function (grunt) {

    var svg = grunt.option('svg');

    grunt.config('svgstore', {

        options: {
            svg: {
                //viewBox: '0 0 100 100',
                xmlns: 'http://www.w3.org/2000/svg'
            }
        },
        default: {
            files: [
                {
                    src:  svg.src,
                    dest: svg.dest
                }
            ]
        }

    });

};
