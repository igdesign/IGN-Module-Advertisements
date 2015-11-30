(function() {
'use strict';

// Dependencies ===============
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var paths = require('../gulp-config').paths;

// Stream =====================
gulp.task('css', function() {
    return gulp.src(`${paths.source.css}/**/*.css`)
        .pipe(gulp.dest(`${paths.build.css}`));
});

})();
