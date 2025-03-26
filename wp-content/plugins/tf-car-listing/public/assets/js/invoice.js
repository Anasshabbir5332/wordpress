(function ($) {
    'use strict';
    var handleInvoicePrint = function () {
        $('#invoice_print').on('click', function (event) {
            event.preventDefault();
            var width_print_window = 900,
                height_print_window = 650,
                left = (screen.width / 2) - (width_print_window / 2),
                top = (screen.height / 2) - (height_print_window / 2),
                invoiceId = $(this).data('invoice-id'),
                ajaxUrl = $(this).data('ajax-url'),
                homeUrl = $(this).data('home-url'),
                invoice_print_window = window.open(homeUrl, 'Invoice ' + invoiceId, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=1, copyhistory=no, width=' + width_print_window + ', height=' + height_print_window + ', top=' + top + ', left=' + left);
            $.ajax({
                type: 'post',
                url: ajaxUrl,
                data: {
                    'action': 'tfcl_handle_print_invoice',
                    'invoice_id': invoiceId
                },
                success: function (data) {
                    invoice_print_window.document.write(data);
                    invoice_print_window.document.close();
                    invoice_print_window.focus();
                },
                error: function (error) {
                    console.log(error);
                }
            })
        })
    }

    $(document).ready(function () {
        handleInvoicePrint();
    })
})(jQuery)