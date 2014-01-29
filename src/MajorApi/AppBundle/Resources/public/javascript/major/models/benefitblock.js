define([
        "underscore"
    ], 
    function (_) {

        var BenefitBlock = function (el) {
            this.el = el;
            this.init();
        };

        BenefitBlock.prototype = {

            init: function () {
                var padding = window.innerHeight * 0.18;
                this.el.style.paddingTop = padding + "px";
                this.el.style.paddingBottom = padding + "px";
            }
        };

        return BenefitBlock;
});