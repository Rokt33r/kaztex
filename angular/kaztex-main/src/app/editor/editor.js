angular.module('kaztex.editor', ['ui.router', 'ui.bootstrap', 'kaztex.core.file'])
	.config(function($stateProvider){
		$stateProvider.state('editor', {
			templateUrl:'editor/editor.tpl.html',
			controller:'EditorController',
			controllerAs:'editor'
		});
	})
	.controller('EditorController', function(){

	})
	.directive('editorSideBar', function(file){
		return {
			scope:{},
			templateUrl:"editor/partials/editor-side-bar.tpl.html",
			link:function(scope, element, attrs){
				scope.fileMap = file.fileMap;
				element.on('click',function(){
					console.log(file.fileMap);
				})
			}
		};
	});