define([
        "underscore",
        "major/comm",
        "tools"
    ], 
    function (_, comm, tools) {

        var HelpBar = function (group) {
            this.group = group;
            this.init();
        };

        HelpBar.prototype = {

            open: function () {
                comm.emitEvent("major.ui.helpbar.open");
                tools.addClass(this.el.panel, "open");                
                this.opened = true;
            },

            close: function () {
                if (this.opened === true) {
                    tools.removeClass(this.el.panel, "open");
                    this.opened = false;
                }
            },
            
            handleClick: function (e, clicked) {
                e.preventDefault();

                var role = clicked.getAttribute("data-ui-helpbar-role");

                if (this.opened === false && role === "open") {
                    this.open();
                    return;
                }

                if (this.opened === true && role === "close") {
                    this.close();
                    return;
                }
            },

            init: function () {
                var helpBar = this;

                helpBar.opened = false;

                helpBar.el = {
                    clickable: document.querySelectorAll("[data-ui-helpbar-group='" + helpBar.group + "'][data-ui-helpbar-role='open'], " +
                                                         "[data-ui-helpbar-group='" + helpBar.group + "'][data-ui-helpbar-role='close']"),
                    panel: document.querySelectorAll("[data-ui-helpbar-group='" + helpBar.group + "'][data-ui-helpbar-role='panel']")[0]
                };

                if (tools.hasClass(helpBar.el.panel, "open")) {
                    helpBar.opened = true;
                }

                _.each(helpBar.el.clickable, function (el) {
                    el.addEventListener("click", function (e) { helpBar.handleClick(e, this); });
                });

                comm.addListener("major.ui.helpbar.open", function () { helpBar.close(); });
            }
        };

        return HelpBar;
});