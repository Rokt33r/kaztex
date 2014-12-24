angular.module('kaztex.core.file', [])
	.factory('file', function($rootScope, $http){

		var fileMap = {};

		var fetchUserFileMap = function(){
			$http.get('/apis/user/files')
				.success(function(data, status){
					fileMap.currentUser = data.files;
					$rootScope.$emit('file:fileMapFetched');
				})
				.error(function(data, status){
					$log.error('fail to fetch file map : ' + data);
				});
		};

		$rootScope.$on('auth:userFetched', fetchUserFileMap);

		return {
			fileMap:fileMap
		};
	});