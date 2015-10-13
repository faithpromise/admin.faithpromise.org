module.exports = function (grunt) {

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
                    src: 'assets/svg/general/*.svg',
                    dest: 'public/build/general.svg'
                }
            ]
        }

    });

};
