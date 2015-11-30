(function() {
'use strict';

// Dependencies ===============
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var paths = require('../gulp-config').paths;

// Stream =====================
gulp.task('javascript', function() {
    return gulp.src(`${paths.source.js}/**/*.js`)
        .pipe(gulp.dest(`${paths.build.js}`));
});

})();
