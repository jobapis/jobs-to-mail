'use strict';
var concat = require('gulp-concat');
var gulp = require('gulp');
var sass = require('gulp-sass');

var paths = {
    srcScss: './resources/assets/sass/*.scss',
    distCss: './public/css',
    srcJs: './resources/assets/js/**/*.js',
    srcBootstrapJs: './node_modules/bootstrap/dist/js/bootstrap.min.js',
    srcIndexJs: './resources/assets/js/app.js',
    srcJqueryJs: './node_modules/jquery/dist/jquery.min.js',
    srcTetherJs: './node_modules/tether/dist/js/tether.min.js',
    distJs: './public/js'
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

// All the JS tasks
gulp.task('js', ['js-bootstrap', 'js-index', 'js-jquery', 'js-tether']);

// Copies Bootstrap JS
gulp.task('js-bootstrap', function() {
    return gulp.src(paths.srcBootstrapJs)
        .pipe(gulp.dest(paths.distJs));
});
// Copies the JS index file
gulp.task('js-index', function() {
    return gulp.src(paths.srcIndexJs)
        .pipe(gulp.dest(paths.distJs));
});
// Copies Jquery
gulp.task('js-jquery', function() {
    return gulp.src(paths.srcJqueryJs)
        .pipe(gulp.dest(paths.distJs));
});
// Copies tether.js
gulp.task('js-tether', function() {
    return gulp.src(paths.srcTetherJs)
        .pipe(gulp.dest(paths.distJs));
});

gulp.task('watch', function() {
    // watch scss files
    gulp.watch(paths.srcScss, ['scss']);
    // Watch JS files
    gulp.watch(paths.srcJs, ['js']);
});

gulp.task('default', ['scss', 'js']);
