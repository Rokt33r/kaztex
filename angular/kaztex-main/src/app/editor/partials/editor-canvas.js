angular.module('kaztex.editor.canvas', [])
	.controller('CanvasController', function($scope, $http){

		var canvas = this;

		$scope.$on('editor:fileSelected', function(e, path){
			canvas.currentFile = path;
			loadFile(path);
		});

		var loadFile = function(path){
			//console.log();
			$http.get('/apis/user/files/'+path+'?mode=load')
				.success(function(res){
					console.log(atob(res.data));
				}).error();
		}

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