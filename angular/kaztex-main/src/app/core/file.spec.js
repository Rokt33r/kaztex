describe("kaztex.core.file", function () {
	var file, $httpBackend, $location, $rootScope;

	var user = {
		name: 'John Doe',
		email: 'foo@example.com'
	};
	var res = {
		"files": [{
			"dirname": "users\/48",
			"basename": ".DS_Store",
			"extension": "DS_Store",
			"filename": "",
			"path": "users\/48\/.DS_Store",
			"type": "file",
			"timestamp": 1419361982,
			"size": 6148
		}, {
			"dirname": "users\/48",
			"basename": "275",
			"filename": "275",
			"path": "users\/48\/275",
			"type": "dir",
			"timestamp": 1419392523
		}, {
			"dirname": "users\/48\/275",
			"basename": "dummy.file",
			"extension": "file",
			"filename": "dummy",
			"path": "users\/48\/275\/dummy.file",
			"type": "file",
			"timestamp": 1419392523,
			"size": 5
		}, {
			"dirname": "users\/48",
			"basename": "dummy.file",
			"extension": "file",
			"filename": "dummy",
			"path": "users\/48\/dummy.file",
			"type": "file",
			"timestamp": 1419391940,
			"size": 5
		}, {
			"dirname": "users\/48",
			"basename": "Gulpfile.js",
			"extension": "js",
			"filename": "Gulpfile",
			"path": "users\/48\/Gulpfile.js",
			"type": "file",
			"timestamp": 1419391184,
			"size": 685
		}, {
			"dirname": "users\/48",
			"basename": "php4k6WjL",
			"filename": "php4k6WjL",
			"path": "users\/48\/php4k6WjL",
			"type": "file",
			"timestamp": 1419390665,
			"size": 567
		}, {
			"dirname": "users\/48",
			"basename": "php8ud47A",
			"filename": "php8ud47A",
			"path": "users\/48\/php8ud47A",
			"type": "file",
			"timestamp": 1419390613,
			"size": 54074
		}]
	};

	beforeEach(module('kaztex.core.file'));
	beforeEach(inject(function ($injector) {

		file = $injector.get('file');

		$httpBackend = $injector.get('$httpBackend');

		$httpBackend.when('GET', '/apis/user/files')
			.respond(res);

		$rootScope = $injector.get('$rootScope');
	}));

	it('should fetch file map of the current user when user authenticated', function () {
		$rootScope.$emit('auth:userFetched');
		spyOn($rootScope, '$emit');
		$httpBackend.expectGET('/apis/user/files');

		$httpBackend.flush();
		expect(file.fileMap).toBeDefined();
		expect(file.fileMap.currentUser).toEqual(res.files);

		expect($rootScope.$emit).toHaveBeenCalledWith('file:fileMapFetched');
	});
});