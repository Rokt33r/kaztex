angular.module('kaztex.partials.top-nav', ['ui.bootstrap'])
	.controller('NavController', function(){

	})
	.directive('topNav', function(){
		return {
			templateUrl: 'partials/top-nav/top-nav.tpl.html'
		};
	});