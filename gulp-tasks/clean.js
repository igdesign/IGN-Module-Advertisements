(function() {
'use strict';

// Module dependencies ========
var gulp = require('gulp');
var del = require('del');

// Configuration ==============
var paths = require('../gulp-config').paths;

///////////////////////////////

gulp.task('clean', function() {
    return del.sync(paths.build.path + "/**/*.*");
});

})();
