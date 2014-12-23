describe("kaztex.core.auth", function (){
	var auth;

	beforeEach(module('kaztex.core.auth'));
	beforeEach(inject(function(_auth_){
		auth = _auth_;
	}));

	it('should have setter & getter for user', function(){
		var user = {
			name:'John Doe',
			email:'foo@example.com'
		};
		auth.setUser(user);

		expect(auth.getUser(user)).toBe(user);
	});
	
});
