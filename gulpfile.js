var gulp = require('gulp');
var batch = require('gulp-batch');
var shell = require('gulp-shell');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');


/**
 * Copy Angular Apps
 **/
var angular = require('./angular.config.js');

var watchTasks = [];
var copyTasks = [];

for(var key in angular){
	
	var app = angular[key];

	gulp.task('copy-' + key, function(){
		gulp.src(app.from + '/**/*')
			.pipe(gulp.dest(app.to));
	});
	copyTasks.push('copy-' + key);

	gulp.task('watch-' + key, function(){
		gulp.watch( app.from + '/**/*', batch({timeout:200}, function(events, done){
			gulp.start('copy-' + key);
			done();
		}));
	});
	watchTasks.push('watch-' + key);

}

gulp.task('watch-ng', watchTasks);
gulp.task('copy', copyTasks);


/**
 * Process SCSS for Laravel App
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
gulp.task('default', ['copy', 'css']);
