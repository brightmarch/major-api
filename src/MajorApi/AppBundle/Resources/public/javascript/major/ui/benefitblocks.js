define([
        "underscore",
        "major/models/benefitblock"
    ], function (_, BenefitBlock) {
        var blocks = {};

        _.each(document.querySelectorAll("[data-ui-benefit-block]"), function (el) {
            var group = el.getAttribute("data-ui-benefit-block");
            if (blocks[group] === undefined) {
                blocks[group] = new BenefitBlock(el);
            }
        });

        return blocks;
});