define([
        "underscore"
    ], 
    function (_) {

        var VoidHolder = function (el) {
            this.el = el;
            this.init();
        };

        VoidHolder.prototype = {

            init: function () {
                var height = this.el.offsetHeight / 2;
                this.el.style.top = "50%";
                this.el.style.marginTop = "-" + height + "px";
            }
            
        };

        return VoidHolder;
});