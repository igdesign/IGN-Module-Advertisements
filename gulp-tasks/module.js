(function() {
'use strict';

// Dependencies ===============
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var paths = require('../gulp-config').paths;

// Stream =====================
gulp.task('module', function() {
    return gulp.src(`${paths.source.module}/**/*`)
        .pipe(gulp.dest(`${paths.build.module}`));
});

})();
