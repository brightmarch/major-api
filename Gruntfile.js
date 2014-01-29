module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),
        watch: {
            scripts: {
                files: [
                    "src/MajorApi/AppBundle/Resources/public/javascript/major.js",
                    "src/MajorApi/AppBundle/Resources/public/javascript/major/**/*"
                ],
                tasks: ["requirejs"]
            },
            styles: {
                files: [
                    "src/MajorApi/AppBundle/Resources/public/css/*.scss"
                ],
                tasks: ["styles"]
            }
        },
        sass: {
            dist: {
                files: {
                    "src/MajorApi/AppBundle/Resources/public/css/majorapi.css": "src/MajorApi/AppBundle/Resources/public/css/majorapi.scss"
                }
            }
        },
        requirejs: {
            compile: {
                options: {
                    baseUrl: "src/MajorApi/AppBundle/Resources/public/javascript/",
                    mainConfigFile: "src/MajorApi/AppBundle/Resources/public/javascript/major.js",
                    paths: {
                        requireLib: "components/requirejs/require"
                    },
                    name: "major",
                    include: "requireLib",
                    out: "src/MajorApi/AppBundle/Resources/public/javascript/major-built.js"
                }
            }
        }
    });

    // r.js plugin
    grunt.loadNpmTasks("grunt-contrib-requirejs");

    // watch plugin
    grunt.loadNpmTasks("grunt-contrib-watch");

    // sass plugin
    grunt.loadNpmTasks("grunt-contrib-sass");

    // grunt tasks
    grunt.registerTask("default", ["requirejs", "sass"]);
    grunt.registerTask("scripts", ["requirejs"]);
    grunt.registerTask("styles", ["sass"]);
};
