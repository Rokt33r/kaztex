module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-nodemon');
    grunt.loadNpmTasks('grunt-concurrent');
    grunt.loadNpmTasks('grunt-html2js');
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-karma');

    var userConfig = require('./build.config.js');

    var taskConfig = {
        pkg: grunt.file.readJSON('package.json'),

        clean:[
            '<%= build_dir %>'
        ],

        copy: {
            appjs: {
                files: [
                    {
                        src: ['<%= app_files.js %>', '<%= vendor_files.js %>'],
                        dest: '<%= build_dir %>',
                        cwd: '.',
                        expand: true
                    }
                ]
            },
            assets: {
                files: [
                    {
                        src: ['<%= vendor_files.css %>', '<%= vendor_files.other %>'],
                        dest: '<%= build_dir %>',
                        cwd: '.',
                        expand: true
                    }
                ]
            }

        },

        watch: {
            jssrc: {
                files: [
                    '<%= app_files.js %>'
                ],
                tasks: ['copy:appjs', 'index']
            },
            atpl: {
                files: [
                    '<%= app_files.atpl %>'
                ],
                tasks: ['html2js']
            },
            html: {
                files: ['<%= app_files.js %>'],
                tasks: ['index:build']
            },
            gruntfile: {
                files: 'Gruntfile.js',
                options: {
                    reload: true
                }
            },
            modules: {
                files: 'src/modules/**/*.js',
                tasks: ['browserify']
            },
            sass: {
                files: 'src/scss/**/*.scss',
                tasks: ['sass']
            },
            index: {
                files: 'src/index.html',
                tasks: ['index:build']
            }
        },

        index: {
            build: {
                dir: '<%= build_dir %>',
                src: [
                    '<%= vendor_files.js %>',
                    '<%= build_dir %>/src/**/*.js',
                    '<%= html2js.app.dest %>',
                    '<%= vendor_files.css %>',
                    '<%= build_dir %>/bundle.js',
                    '<%= build_dir %>/**/*.css'
                ]
            }
        },

        html2js: {
            app: {
                options: {
                    base: 'src/app'
                },
                src: ['<%= app_files.atpl %>'],
                dest: '<%= build_dir %>/templates-app.js'
            }
        },

        browserify: {
            build: {
                src: ['src/modules/modules.js'],
                dest: '<%= build_dir %>/bundle.js',
                options: {
                    debug: true
                }
            }
        },

        sass: {
            options: {
                sourceMap: true
            },
            dist:{
                files: {
                    '<%= build_dir %>/main.css': 'src/scss/main.scss'
                }
            }
        },

        nodemon: {
            dev: {
                script: 'server/server.js',
                options: {
                    watch: ['server']
                }
            }
        },

        karma: {
            unit: {
                configFile: 'karma.conf.js'
            }
        },

        concurrent: {
            dev: {
                tasks: ['karma', 'watch'],

                options: {
                    logConcurrentOutput: true
                }
            }
        }

    };

    grunt.initConfig(grunt.util._.extend(taskConfig, userConfig));

    grunt.registerTask('default', ['build', 'concurrent']);
    grunt.registerTask('build', ['clean', 'copy', 'html2js', 'browserify', 'sass', 'index']);


    function filterForExtension(extension, files) {
        var regex = new RegExp('\\.' + extension + '$');
        var dirRE = new RegExp('^(' + grunt.config('build_dir') + ')\/', 'g');
        return files.filter(function (file) {
            return file.match(regex);
        }).map(function (file){
            return file.replace(dirRE, '');
        });
    }

    grunt.registerMultiTask('index', 'Process index.html template', function(){

        var jsFiles = filterForExtension('js', this.filesSrc);
        var cssFiles = filterForExtension('css', this.filesSrc);

        //grunt.log.writeln(this.filesSrc);

        grunt.file.copy('src/index.html', this.data.dir + '/index.html', {
            process: function (contents, path) {
                return grunt.template.process(contents, {
                    data: {
                        scripts: jsFiles,
                        styles: cssFiles,
                        version: grunt.config('pkg.version')
                    }
                });
            }
        });
    });
}