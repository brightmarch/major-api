require.config({
    paths: {
        underscore: "components/underscore-amd/underscore-min",
        eventEmitter: "components/eventEmitter/EventEmitter.min",
        tools: "major/tools/tools",
        stripe: "https://js.stripe.com/v1/?" // ? is a hack to keep require from appending the .js
    }
});

require(
    [
        "major/ui/helpbars",
        "major/ui/droplists",
        "major/ui/billingforms",
        "major/ui/benefitblocks",
        "major/ui/voidholders",
        "major/comm"
    ],
    function () {
        // console.log("The Major app has loaded");
    }
);
