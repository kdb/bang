'use strict';

module.exports = function (grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Watch for changes and trigger compass with livereload on CSS files.
    watch: {
      scss: {
        options: {
          livereload: false
        },
        files: ['stylesheets/scss/*.scss'],
        tasks: ['compass']
      },
      css: {
        files: ['stylesheets/*.css'],
        options: {
          livereload: true
        }
      }
    },

    // Compass and SCSS
    compass: {
      options: {
        httpPath: '/profiles/ding2/themes/bang',
        cssDir: 'stylesheets',
        sassDir: 'stylesheets/scss',
        imagesDir: '../../libraries/kkb_styleguide/_/img',
        assetCacheBuster: 'none'
      },
      prod: {
        options: {
          environment: 'production',
          outputStyle: 'compressed',
          noLineComments : true,
          force: true,
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');

  grunt.registerTask('default', [
    'compass',
    'watch'
  ]);
};