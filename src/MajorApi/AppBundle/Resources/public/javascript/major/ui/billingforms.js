define([
        "underscore",
        "major/models/billingform",
        "stripe"
    ], function (_, BillingForm, stripe) {
        var billingForms = {};

        // activate stripe
        stripe.setPublishableKey("pk_live_01I1F2drgl6jUhGJejUh9RRR");

        // attach functionality to billing forms
        _.each(document.querySelectorAll("[data-ui-billing-form]"), function (link) {
            var group = link.getAttribute("data-ui-billing-form");
            if (billingForms[group] === undefined) {
                billingForms[group] = new BillingForm(group);
            }
        });

        return billingForms;
});
