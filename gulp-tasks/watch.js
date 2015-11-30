(function() {
'use strict';

// Dependencies ===============
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var paths = require('../gulp-config').paths;

gulp.task('watch', function() {
    $.watch(`${paths.source.css}/**/*.css`, $.batch(function(events, done) {
        gulp.start(['css'], done);
    }));

    $.watch(`${paths.source.js}/**/*.js`, $.batch(function(events, done) {
        gulp.start(['javascript'], done);
    }));

    $.watch(`${paths.source.tmpl}/**/*.tmpl`, $.batch(function(events, done) {
        gulp.start(['templates'], done);
    }));

    $.watch([`${paths.source.path}/**/*.php`,
             `${paths.source.path}/**/*.xml`], $.batch(function(events, done) {
        gulp.start(['module'], done);
    }));
});

})();
