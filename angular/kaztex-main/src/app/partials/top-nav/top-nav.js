angular.module('kaztex.partials.top-nav', [])
	.controller('NavController', function($scope){
		$scope.message = ' /  hello!!';
		this.msg = 'msg fr ctrl'
	})
	.directive('topNav', function(){
		return {
			template: '<div ng-controller="NavController as nav">Top Nav{{message}} {{nav.msg}}</div>'
		};
	});