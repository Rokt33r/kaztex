module.exports = {
    build_dir: "build",

    app_files: {
        js: ['src/app/**/*.js', '!src/app/**/*.spec.js'],
        atpl: ['src/app/**/*.tpl.html'],
        html: ['src/index.html']
    },

    vendor_files:{
        js: [
            'vendor/lodash/dist/lodash.js',
            'vendor/angular/angular.js',
            'vendor/angular-animate/angular-animate.js',
            'vendor/angular-ui-router/release/angular-ui-router.js',
            'vendor/angular-bootstrap/ui-bootstrap-tpls.js',
            'vendor/fastclick/lib/fastclick.js'
        ]
    }
}