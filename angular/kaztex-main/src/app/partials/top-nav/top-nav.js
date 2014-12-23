angular.module('kaztex.partials.top-nav', ['ui.bootstrap', 'kaztex.core.auth'])
	.controller('TopNavController', function($rootScope, auth){
		var nav = this;
		nav.user = {};
		$rootScope.$on('auth:userFetched', function(e){
			nav.user = auth.getUser();
		});
	})
	.directive('topNav', function(){
		return {
			templateUrl: 'partials/top-nav/top-nav.tpl.html'
		};
	});