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
]).run(function($state){
    $state.go('editor');
});