var elixir = require('laravel-elixir');
var gulp = require('gulp');
var shell = require('gulp-shell');
var angular = require('./angular.config.js');

var watchTasks = [];
var buildTasks = [];

for(var key in angular){
	var app = angular[key];
	gulp.task('watch-' + key, function(){
		gulp.watch( app.from + '/**/*', ['build']);
	});
	watchTasks.push('watch-' + key);

	gulp.task('build-' + key, function(){
		gulp.src(app.from + '/**/*')
			.pipe(gulp.dest(app.to));
	});
	buildTasks.push('build-' + key);
}

gulp.task('build-watch', watchTasks);
gulp.task('build', buildTasks);


elixir(function(mix) {
	mix.sass("app.scss");
});