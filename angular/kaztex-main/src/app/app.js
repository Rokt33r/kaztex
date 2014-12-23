angular.module('kaztex', [
    // plugins
    'ui.router',
    'ui.bootstrap',

    // templates
    'templates-app',

    // modules
    'kaztex.core',
    'kaztex.partials',

    // states
    'kaztex.editor'
])
    .config(function($httpProvider){
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With']
    })

    .run(function($state){
        $state.go('editor');
});