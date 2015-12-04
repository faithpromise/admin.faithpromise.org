module.exports = function (grunt) {

    var release_root = grunt.option('release_root');

    grunt.config('git_deploy', {

        production: {
            options: {
                url:    'git@github.faithpromise.org:faithpromise/admin.faithpromise.org.git',
                branch: 'release'
            },
            src:     release_root
        }

    });

};
