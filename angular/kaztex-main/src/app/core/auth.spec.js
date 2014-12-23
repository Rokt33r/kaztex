describe("kaztex.core.auth", function (){
	var auth, $httpBackend, $location;

	var user = {
		name:'John Doe',
		email:'foo@example.com'
	};

	beforeEach(module('kaztex.core.auth'));
	beforeEach(inject(function($injector){
		$httpBackend = $injector.get('$httpBackend');

		$httpBackend.when('GET', '/apis/user')
			.respond({
				user:{
					email:'foo@example.com',
					name:'John Doe',
					created_at:'2014-12-12'
				}
			});

		auth = $injector.get('auth');

		$location = $injector.get('$location');

	}));

	it('should have setter & getter for user', function(){
		auth.setUser(user);

		expect(auth.getUser()).toBe(user);
	});

	it('should send a request to fetch user info', function(){
		$httpBackend.expectGET('/apis/user').respond(200, {});
		$httpBackend.flush();
	});

	it('should fetch user when initialize', function(){
		$httpBackend.flush();

		var fetchedUser = auth.getUser();

		expect(fetchedUser.name).toBe(user.name);
		expect(fetchedUser.email).toBe(user.email);
	});

	it('should redirect when getting status 401', function(){
		spyOn($location, 'path');

		$httpBackend.expectGET('/apis/user')
			.respond(401, {});
		$httpBackend.flush();

		expect($location.path).toHaveBeenCalledWith('/signin');
	});
});
