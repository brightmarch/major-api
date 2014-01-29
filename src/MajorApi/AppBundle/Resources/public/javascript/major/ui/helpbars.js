define([
        "underscore",
        "major/models/helpbar"
    ], function (_, HelpBar) {
        var helpBars = {};

        _.each(document.querySelectorAll("[data-ui-helpbar-role='open']"), function (link) {
            var group = link.getAttribute("data-ui-helpbar-group");
            if (helpBars[group] === undefined) {
                helpBars[group] = new HelpBar(group);
            }
        });

        return helpBars;
});