module.exports = function (grunt) {

    var ng           = grunt.option('ng'),
        fontello     = grunt.option('fontello'),
        release_root = grunt.option('release_root');

    grunt.config('copy', {

        ng_templates: {
            expand: true,
            cwd:    ng.root,
            src:    '**/*.html',
            dest:   ng.dest
        },

        fontello: {
            expand:  true,
            flatten: true,
            src:     fontello.src,
            dest:    fontello.dest
        },

        release: {
            expand: true,
            src:    [
                // Include
                './**/*.*',
                './artisan',
                './storage/.gitkeep', // Note: keep storage dir or Envoyer will not create symlink
                './bootstrap/cache/.gitkeep', // Note: director required for Artisan when deploying
                // Exclude
                '!./**/*.log',
                '!./assets/**/*',
                '!./bower_components/**/*',
                '!./js/**/*',
                '!./less/**/*',
                '!./node_modules/**/*',
                '!./storage/debugbar/**/*',
                '!./temp/**/*',
                '!./vendor/**/*',
                '!./_ide_helper.php',
                '!./bower.json',
                '!./Homestead.yaml.example',
                '!./Gruntfile.js',
                '!./package.json',
                '!./phpspec.yml',
                '!./phpunit.xml',
                '!./readme.md',
                '!./server.php',
                '!./TODO.txt'
            ],
            dest:   release_root
        }

    });

};
