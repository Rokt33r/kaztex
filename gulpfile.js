var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');

/**
 * Build and Copy Angular Apps
 **/
var shell = require('gulp-shell');
var angular = require('./angular.config.js');

var watchTasks = [];
var buildTasks = [];

for(var key in angular){
	var app = angular[key];

	gulp.task('build-' + key, function(){
		gulp.src(app.from + '/**/*')
			.pipe(gulp.dest(app.to));
	});
	buildTasks.push('build-' + key);

	gulp.task('watch-' + key, function(){
		gulp.watch( app.from + '/**/*', ['build'+key]);
	});
	watchTasks.push('watch-' + key);

}

gulp.task('build-watch', watchTasks);
gulp.task('build', buildTasks);


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

gulp.task('watch', function(){
	gulp.watch('app/assets/sass/**/*.scss', ['css']);
});