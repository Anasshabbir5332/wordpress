(function ($) {
    'use strict';
    var showWireTransferInformation = function () {
        $('input[type=radio][name=payment_method]').on('change', function () {
            if ($(this).val() == 'wire_transfer') {
                $('.wire-transfer-info').show();
            } else {
                $('.wire-transfer-info').hide();
            }
        })
    }

    var executePaymentByPaypal = function (packageId) {
        var securityPassword = $('#tfcl_security_payment').val();
        $.ajax({
            type: 'post',
            url: payment_variables.ajax_url,
            data: {
                'action': 'tfcl_handle_payment_invoice_by_paypal',
                'package_id': packageId,
                'tfcl_security_payment': securityPassword
            },
            beforeSend: function () {
                $('#payment_per_package').append(' <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (data) {
                $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                window.location.href = data;
            },
            error: function (xhr, status, error) {
                // Handle the registration error response
                $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                console.log(error);
            }
        });
    }

    var executePaymentByWireTransfer = function (packageId) {
        var securityPassword = $('#tfcl_security_payment').val();
        $.ajax({
            type: 'post',
            url: payment_variables.ajax_url,
            data: {
                'action': 'tfcl_handle_payment_invoice_by_wire_transfer',
                'package_id': packageId,
                'tfcl_security_payment': securityPassword
            },
            beforeSend: function () {
                $('#payment_per_package').append(' <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (data) {
                $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                window.location.href = data;
            },
            error: function (xhr, status, error) {
                // Handle the registration error response
                $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                console.log(error);
            }
        });
    }

    var handleFreePackage = function () {
        $('#free_package').on('click', function (event) {
            event.preventDefault();
            var packageID = $('input[name=package_id]').val();
            var securityPassword = $('#tfcl_security_payment').val();
            $.ajax({
                type: 'post',
                url: payment_variables.ajax_url,
                data: {
                    'action': 'tfcl_handle_free_package',
                    'package_id': packageID,
                    'tfcl_security_payment': securityPassword
                },
                beforeSend: function () {
                    $('#payment_per_package').append(' <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (data) {
                    $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                    window.location.href = data;
                },
                error: function (xhr, status, error) {
                    // Handle the registration error response
                    $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                    console.log(error);
                }
            })
        })
    }

    var executeStripeCheckout = function (packageId = null) {
        if (payment_variables.stripe_version == 'new') {
            var securityPassword = $('#tfcl_security_payment').val();
            const stripe = Stripe(payment_variables.stripe_publishable_key);
            $.ajax(
                {
                    type: 'post',
                    url: payment_variables.ajax_url,
                    data: {
                        'action': 'stripe_payment_init',
                        'packageID': packageId,
                        'tfcl_security_payment': securityPassword
                    },
                    beforeSend: function () {
                        $('#payment_per_package').append(' <i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function (data) {
                        $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                        data = JSON.parse(data);
                        if (data.session.id) {
                            stripe.redirectToCheckout({
                                sessionId: data.session.id,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle the registration error response
                        $('#payment_per_package').children('i').removeClass('fa-spinner fa-spin');
                        console.log(error);
                    }
                }
            );
        } else {
            var form = $('.stripe-payment-form');
            if (form.length == 0) return;
            var submitFormBtn = form.find('.stripe-checkout-button');
            var formID = form.attr('id');
            var formData = stripe_variables[formID];
            var stripeHandler = null;

            if (submitFormBtn.length) {
                stripeHandler = StripeCheckout.configure({
                    // Key data MUST be sent here instead of stripeHandler.open().
                    key: formData.key,
                    token: function (token, args) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'stripeToken',
                            value: token.id
                        }).appendTo(form);

                        $('<input>').attr({
                            type: 'hidden',
                            name: 'stripeTokenType',
                            value: token.type
                        }).appendTo(form);

                        if (token.email) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'stripeEmail',
                                value: token.email
                            }).appendTo(form);
                        }
                        form.submit();
                    },
                });

                submitFormBtn.on('click', function (event) {
                    event.preventDefault();
                    stripeHandler.open(formData.data);
                });
            }
            window.addEventListener('popstate', function () {
                if (stripeHandler != null) {
                    stripeHandler.close();
                }
            })
        }
    }

    var handlePaymentInvoice = function () {
        $('#payment_per_package').on('click', function (event) {
            event.preventDefault();
            var paymentMethod = $('input[type=radio][name=payment_method]:checked').val();
            var packageID = $('input[name=package_id]').val();
            switch (paymentMethod) {
                case 'paypal':
                    executePaymentByPaypal(packageID);
                    break;
                case 'wire_transfer':
                    executePaymentByWireTransfer(packageID);
                    break;
                case 'stripe':
                    if (payment_variables.stripe_version == 'new') {
                        executeStripeCheckout(packageID);
                    }
                    else {
                        $('.stripe-payment-form .stripe-checkout-button').trigger('click');
                    }
                    break;
                default:
                    break;
            }
        })
    }

    var returnRefinedURL = function (key, url) {
        return url.replace(new RegExp(key + "=\\w+"), "").replace("?&", "?")
            .replace("&&", "&");
    }

    var handleAfterStripePaymentSuccess = function () {
        var urlParams = new URLSearchParams(window.location.search); //get all parameters
        var session_id = urlParams.get('session_id');
        if (session_id) {
            window.location.href = returnRefinedURL('session_id', window.location.search);
        }
    }

    $(document).ready(function () {
        handleAfterStripePaymentSuccess();
        if (payment_variables.stripe_version == 'legacy') {
            executeStripeCheckout();
        }
        $('.wire-transfer-info').hide();
        showWireTransferInformation();
        handlePaymentInvoice();
        handleFreePackage();
    })
})(jQuery);