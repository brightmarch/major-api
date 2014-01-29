define([
        "underscore",
        "major/models/dropList"
    ], function (_, DropList) {
        var dropLists = {};


        _.each(document.querySelectorAll("[data-ui-droplist-role='open']"), function (link) {
            var group = link.getAttribute("data-ui-droplist-group");
            if (dropLists[group] === undefined) {
                dropLists[group] = new DropList(group);
            }
        });

        return dropLists;
});
