angular.module('kaztex.editor.sidebar', [
	'kaztex.core.file'])
	.controller('EditorSideBarController', function(file, $scope){
		var sidebar = this;

		sidebar.fileMap = file.fileMap;
		sidebar.selectFile = function(file){
			sidebar.selectedFile = file;
		};
		console.log(sidebar);

		$scope.$on('editor:fileSelected', function(e, path){
			console.log(path);
		});
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
	.directive('editorSideBarFile', function($compile, $rootScope){
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
				element.on('click', function(e){
					$rootScope.$broadcast('editor:fileSelected', scope.file.path);
					e.stopPropagation();
				});
				scope.$on('editor:fileSelected', function(e, path){
					if(scope.file.path==path){
						element.addClass('selected');
					}else{
						element.removeClass('selected');
					}
				});
			}
		};
	});