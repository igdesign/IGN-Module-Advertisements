(function() {
'use strict';

// Dependencies ===============
var gulp = require('gulp');
var runSequence = require('run-sequence');
var $ = require('gulp-load-plugins')();
var config = require('../gulp-config');

// Stream =====================
gulp.task('default', function(callback) {
    runSequence('clean',
                ['module', 'templates'],
                ['javascript', 'css'],
                'watch',
                callback);
});

})();
