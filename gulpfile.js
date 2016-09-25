'use strict';
var concat = require('gulp-concat');
var gulp = require('gulp');
var sass = require('gulp-sass');

var paths = {
    srcScss: './resources/assets/sass/*.scss',
    distCss: './public/css'
    // srcJsIndex: './src/js/app.js',
    // srcJs: './resources/assets/js/**/*.js',
    // distJs: './public/js'
};

// SCSS Options
var scssOpts = {
    noCache: true,
    style: "expanded",
    lineNumbers: true,
    loadPath: paths.srcScss
};

gulp.task('scss', function() {
    return gulp.src(paths.srcScss)
        .pipe(sass(scssOpts))
        .pipe(concat('app.css'))
        .pipe(gulp.dest(paths.distCss));
});

gulp.task('watch', function() {
    // watch scss files
    gulp.watch(paths.srcScss, ['scss']);
    // Watch JS files
    // gulp.watch(paths.srcJs, ['js']);
});

gulp.task('default', ['scss'/*, 'js'*/]);
