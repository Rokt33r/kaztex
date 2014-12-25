angular.module('kaztex.editor.sidebar', [
	'kaztex.core.file'])
	.controller('EditorSideBarController', function(file){
		var sidebar = this;

		sidebar.fileMap = file.fileMap;

	})
	.directive('editorSideBar', function(file){
		return {
			scope:{},
			controller:'EditorSideBarController',
			controllerAs:'sidebar',
			templateUrl:"editor/partials/editor-side-bar.tpl.html",
			link:function(scope, element, attrs){

			}
		};
	})
	.directive('editorSideBarFile', function(){
		return{
			scope:{
				file:'=file'
			},
			templateUrl:'editor/partials/editor-side-bar-file.tpl.html'
		};
	});