module.exports = function (grunt) {

    grunt.registerTask('deploy_production', [

        // build files
        '_build_release',

        // push to release branch
        'git_deploy:production',

        // clean release dir so we don't mistakenly
        // work on release files
        'clean:release',

        // restore dev files
        'clean:build',
        'build_dev'

    ]);

};
