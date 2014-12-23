angular.module('kaztex.core.auth', [])
	.run(function($http, $location, auth){
		$http.get('/apis/user')
			.success(function(data, status, headers, config){
				var user = data.user;
				auth.setUser(user);
		})
			.error(function(data, status, headers, config){
				if(status===401){
					$log.log('Redirect to Sign in page.');
					$location.path('/signin');
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