({
    mainConfigFile: '../major.js',
    baseUrl: "../",
    paths: {
        requireLib: "components/requirejs/require"
    },
    name: "major",
    include: "requireLib",
    out: "../major-built.js"
})