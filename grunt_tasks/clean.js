module.exports = function (grunt) {

    var build_root   = grunt.option('build_root'),
        release_root = grunt.option('release_root');

    grunt.config('clean', {

        build:   [build_root + '/*', '!' + build_root + '/.gitkeep'],
        release: [release_root + '/*', '!' + release_root + '/.gitkeep']

    });

};
