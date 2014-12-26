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
	.directive('editorSideBarDir', function(){
		return {
			replace: true,
			scope:{
				files: '='
			},
			templateUrl:"editor/partials/editor-side-bar-dir.tpl.html",
		}
	})
	.directive('editorSideBarFile', function($compile){
		return{
			scope:{
				file:'='
			},
			templateUrl:'editor/partials/editor-side-bar-file.tpl.html',
			link:function(scope, element, attr){
				if(scope.file.subFiles){
					element.append('<editor-side-bar-dir files="file.subFiles"></editor-side-bar-dir>');
					$compile(element.contents())(scope)
				}
			}
		};
	});