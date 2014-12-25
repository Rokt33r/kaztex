angular.module('kaztex.editor.canvas', [])
	.controller('CanvasController', function(){

	})
	.directive('editorCanvas', function($log, $document){
		return {
			scope:{},
			controller:'CanvasController',
			controllerAs:'canvas',
			templateUrl:"editor/partials/editor-canvas.tpl.html",
			link:function(scope, element){
			}
		}
	});