angular.module('kaztex.core.auth', [])
	.run(function($http, $location, auth, $rootScope){
		$http.get('/apis/user')
			.success(function(data, status, headers, config){
				var user = data.user;
				auth.setUser(user);
				$rootScope.$emit('auth:userFetched');
		})
			.error(function(data, status, headers, config){
				if(status===401){
					$location.path('/signin');
					location.pathname = 'signin';
				}else{
					$log.error('data');
				}
			});
	})
	.factory('auth', function($http){
		var auth = this;

		var setUser = function(user){
			auth.user = user;
		};

		var getUser = function(){
			return auth.user;
		};

		return {
			setUser:setUser,
			getUser:getUser
		}
	});