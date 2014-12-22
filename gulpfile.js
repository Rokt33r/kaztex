var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');

/**
 * fetch and Copy Angular Apps
 **/
var shell = require('gulp-shell');
var angular = require('./angular.config.js');

var watchTasks = [];
var fetchTasks = [];

for(var key in angular){
	var app = angular[key];

	gulp.task('fetch-' + key, function(){
		gulp.src(app.from + '/**/*')
			.pipe(gulp.dest(app.to));
	});
	fetchTasks.push('fetch-' + key);

	gulp.task('watch-' + key, function(){
		gulp.watch( app.from + '/**/*', ['fetch'+key]);
	});
	watchTasks.push('watch-' + key);

}

gulp.task('watch-ng', watchTasks);
gulp.task('fetch', fetchTasks);


/**
 * SCSS->CSS for Laravel App
 **/

gulp.task('css', function(){
	gulp.src('app/assets/sass/main.scss')
		.pipe(sass({errLogToConsole: true}))
		.pipe(autoprefixer('last 10 version'))
		.pipe(minifyCSS({keepBraks:true}))
		.pipe(gulp.dest('public/css'))
});

gulp.task('watch-css', function(){
	gulp.watch('app/assets/sass/**/*.scss', ['css']);
});

/**
 * Process All & Watch All
 **/
gulp.task('watch', ['watch-ng', 'watch-css']);
gulp.task('default', ['fetch', 'css']);