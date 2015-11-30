(function() {
'use strict';

// Dependencies ===============
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var paths = require('../gulp-config').paths;

// Stream =====================
gulp.task('templates', function() {
    return gulp.src(`${paths.source.tmpl}/**/*`)
        .pipe(gulp.dest(`${paths.build.tmpl}`));
});

})();
