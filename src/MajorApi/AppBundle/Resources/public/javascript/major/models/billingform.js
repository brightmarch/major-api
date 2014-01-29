define([
        "underscore",
        "major/comm",
        "tools",
        "stripe"
    ], 
    function (_, comm, tools, stripe) {

        var BillingForm = function (group) {
            this.group = group;
            this.init();
        };

        BillingForm.prototype = {

            clearErrors: function () {
                tools.removeClass(this.el.errors, "margin-top-1-0");
                tools.addClass(this.el.errors, "hidden");
                this.errorLog = "";
                this.valid = true;
            },

            logError: function (error) {
                this.errorLog += "<li>" + error + "</li>";
                this.valid = false;
            },

            showErrors: function () {
                tools.addClass(this.el.errors, "margin-top-1-0");
                tools.removeClass(this.el.errors, "hidden");
                this.el.errors.innerHTML = "<ul class='no-bullets'>" + this.errorLog + "</ul>";
            },

            proccessStripe: function (response) {
                var form = this;

                if (response.error !== undefined) {
                    tools.removeClass(form.el.form, "async");
                    form.el.submit.removeAttribute("disabled");

                    form.clearErrors();
                    form.logError(response.error.message);
                    form.showErrors();
                } else {
                    form.el.billingToken.value = response.id;
                    form.el.billingDigits.value = response.card.last4;
                    form.el.billingType.value = response.card.type;
                    form.el.form.submit();
                }
            },

            generateToken: function () {
                var form = this;

                stripe.createToken({
                    number: form.el.number.value,
                    cvc: form.el.cvc.value,
                    exp_month: form.el.expMonth.value,
                    exp_year: form.el.expYear.value
                }, function (status, response) { form.proccessStripe(response); });
            },

            validate: function (e, el) {
                e.preventDefault();

                var form = this;

                form.clearErrors();

                if (!stripe.validateCardNumber(form.el.number.value)) {
                    form.logError("The card number appears to be invalid.");
                }

                if (!stripe.validateExpiry(form.el.expMonth.value, form.el.expYear.value)) {
                    form.logError("The expiration date appears to be invalid.");
                }

                if (!stripe.validateCVC(form.el.cvc.value)) {
                    form.logError("The CVC appears to be invalid.");
                }

                if (form.valid) {
                    tools.addClass(form.el.form, "async");
                    form.el.submit.setAttribute("disabled", "true");
                    form.generateToken();
                } else {
                    form.showErrors();
                }
            },

            init: function () {
                var form = this;

                form.valid = false;
                form.errorLog = "";

                form.el = {};
                form.el.form = document.querySelectorAll("[data-ui-billing-form='" + form.group + "']")[0];
                form.el.errors = document.querySelectorAll("[data-ui-billing-errors='" + form.group + "']")[0];
                form.el.number = document.querySelectorAll("#accountBilling_cardNumber")[0];
                form.el.expMonth = document.querySelectorAll("#accountBilling_expirationMonth")[0];
                form.el.expYear = document.querySelectorAll("#accountBilling_expirationYear")[0];
                form.el.cvc = document.querySelectorAll("#accountBilling_cvc")[0];
                form.el.billingToken = document.querySelectorAll("#accountBilling_billingToken")[0];
                form.el.billingDigits = document.querySelectorAll("#accountBilling_billingDigits")[0];
                form.el.billingType = document.querySelectorAll("#accountBilling_billingType")[0];
                form.el.submit = document.querySelectorAll("input[type='submit']")[0];

                form.el.form.addEventListener("submit", function (e) { form.validate(e, this); });
            }

        };

        return BillingForm;
});
