define([
        "underscore",
        "tools"
    ], 
    function (_, tools) {

        var DropList = function (group) {
            this.group = group;
            this.init();
        };

        DropList.prototype = {

            open: function () {
                this.el.items.style.height = this.height + "px";
                tools.addClass(this.el.list, "open");                
                this.opened = true;
            },

            close: function () {
                this.el.items.style.height = "0";
                tools.removeClass(this.el.list, "open");
                this.opened = false;
            },
            
            handleClick: function (e, clicked) {
                e.preventDefault();

                if (this.opened === false) {
                    this.open();
                    return;
                }

                if (this.opened === true) {
                    this.close();
                    return;
                }
            },

            init: function () {
                var dropList = this;

                dropList.opened = false;
                dropList.height = 0;

                dropList.el = {
                    opens: document.querySelectorAll("[data-ui-droplist-group='" + dropList.group + "'][data-ui-droplist-role='open']"),
                    items: document.querySelectorAll("[data-ui-droplist-group='" + dropList.group + "'][data-ui-droplist-role='items']")[0], // what a shitty name you asshole
                    list: document.querySelectorAll("[data-ui-droplist-group='" + dropList.group + "'][data-ui-droplist-role='list']")[0]
                };

                _.each(dropList.el.opens, function (el) {
                    el.addEventListener("click", function (e) { dropList.handleClick(e, this); });
                });

                _.each(dropList.el.items.children, function(child) { 
                    dropList.height += child.offsetHeight;
                });
            }
        };

        return DropList;
});