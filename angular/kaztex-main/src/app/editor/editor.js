angular.module('kaztex.editor', [
	'ui.router',
	'ui.bootstrap',

	'kaztex.core.file',

	'kaztex.editor.canvas',
	'kaztex.editor.sidebar'
])
	.config(function($stateProvider){
		$stateProvider.state('editor', {
			templateUrl:'editor/editor.tpl.html',
			controller:'EditorController',
			controllerAs:'editor'
		});
	})
	.controller('EditorController', function(){

	});