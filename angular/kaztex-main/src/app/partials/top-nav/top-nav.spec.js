describe('kaztex.partials.top-nav', function(){

	var TopNavController, $rootScope, auth;

	var user = {
		name:'John Doe',
		email:'foo@example.com'
	};

	beforeEach(module('kaztex.partials.top-nav'));
	beforeEach(inject(function($injector, $controller){
		TopNavController = $controller('TopNavController', {});

		$rootScope = $injector.get('$rootScope');

		auth = $injector.get('auth');
	}));

	it('should refresh its scope when user fetched', function(){
		auth.setUser(user);
		$rootScope.$emit('auth:userFetched');

		expect(TopNavController.user).toBe(user);
	});
});