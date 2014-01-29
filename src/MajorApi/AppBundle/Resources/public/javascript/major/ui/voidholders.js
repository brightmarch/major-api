define([
        "underscore",
        "major/models/voidholder"
    ], function (_, VoidHolder) {
        var holders = {};

        _.each(document.querySelectorAll("[data-ui-void-holder]"), function (el) {
            var group = el.getAttribute("data-ui-void-holder");
            if (holders[group] === undefined) {
                holders[group] = new VoidHolder(el);
            }
        });

        return holders;
});