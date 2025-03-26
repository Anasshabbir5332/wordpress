jQuery(document).ready(function ($) {
    $('.colorpicker').wpColorPicker();
    $("#mytabs .hidden").removeClass('hidden');
    $("#mytabs").tabs();

    function inputFloatNumber(selector) {
        $(selector).on('input', function (e) {
            var input = $(this);
            var oldVal = input.val();
            var floatNumberVal = oldVal.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            input.val(floatNumberVal);
        });
    }

    inputFloatNumber("input[type='text']#engine_size");

    function disableNegativeNumberInput() {
        $("input[type='number']").on('input', function (e) {
            var input = $(this),
                oldVal = input.val(),
                newVal = (parseFloat(oldVal) < 0) ? oldVal * -1 : oldVal;
            if (newVal != 0) {
                input.val(newVal);
            }
        });
    }

    disableNegativeNumberInput();

    // reorder package detail after title
    if (tfcl_main_vars.post_type_now == 'package') {
        $('#postdiv, #postdivrich').hide();
    }

    // Detection if an element is added to DOM
    function onElementInserted(containerSelector, elementSelector, callback) {
        var onMutationsObserved = function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.addedNodes.length) {
                    var elements = $(mutation.addedNodes).find(elementSelector);
                    for (var i = 0, len = elements.length; i < len; i++) {
                        callback(elements[i]);
                    }
                }
            });
        };

        var target = $(containerSelector)[0];
        if (!target) {
            // The node target we need does not exist yet.
            // Wait 300ms and try again
            window.setTimeout(onElementInserted, 300);
            return;
        }
        var config = { childList: true, subtree: true };
        var MutationObserver = window.MutationObserver || window.WebKitMutationObserver;
        var observer = new MutationObserver(onMutationsObserved);
        observer.observe(target, config);
    };

    // Update index field name
    $('.redux-repeater-accordion').sortable({
        update: function (event, ui) {
            event = null;
            $(this).find('.redux-repeater-accordion-repeater').each(function (idx, elm) {
                var multiInput = $(this).find('.redux-field ul.repeater');
                multiInput.find('li').each(function () {
                    var name = $(this).find('input').attr('name').replace(/\[\d\]/, '[' + idx + ']');
                    $(this).find('input').attr('name', name);
                });
                var id = $(this).attr('data-sortid');
                var input = $(this).find('.redux-field .repeater[name*=\'[' + id + ']\']');

                input.each(
                    function () {
                        $(this).attr('name', $(this).attr('name').replace(/\[\d\]/, '[' + idx + ']'));
                    }
                );

                input = $(this).find('.slide-title');
                input.attr('name', input.attr('name').replace(/\[\d\]/, '[' + idx + ']'));
                input.attr('data-key', idx);

                $(this).attr('data-sortid', idx);

                // Fix the accordion header.
                header = $(this).find('.ui-accordion-header');
                split = header.attr('id').split('-header-');

                header.attr('id', split[0] + '-header-' + idx);
                split = header.attr('aria-controls').split('-panel-');

                header.attr('aria-controls', split[0] + '-panel-' + idx);

                // Fix the accordion content.
                content = $(this).find('.ui-accordion-content');
                split = content.attr('id').split('-panel-');

                content.attr('id', split[0] + '-panel-' + idx);
                split = content.attr('aria-labelledby').split('-header-');

                content.attr('aria-labelledby', split[0] + '-header-' + idx);
            })
        }
    });

    // Set value additional field name
    $('input[name*=additional_field_label]').on('focusout', function () {
        var label = $(this).val(),
            name = label.replace(/[^a-zA-Z 0-9 ]/g, '').replace(/\s+/g, '-').toLowerCase();
        $(this).parent().next().next().find('input[name*=additional_field_name]').val(name);
    });
    onElementInserted('.redux-repeater-accordion', 'input[name*=additional_field_label]', function (e) {
        $('input[name*=additional_field_label]').on('focusout', function () {
            var label = $(this).val(),
                name = label.replace(/[^a-zA-Z 0-9 ]/g, '').replace(/\s+/g, '-').toLowerCase();
            $(this).parent().next().next().find('input[name*=additional_field_name]').val(name);
        });
    });

    // Show input options value when field type is select or radio or type
    $('select[name*=additional_field_type]').each(function (i, el) {
        var fieldType = $(el).val();
        if (fieldType === 'select' || fieldType === 'radio' || fieldType === 'checkbox') {
            $(el).parent('fieldset').next().show();
            $(el).parent('fieldset').next().next().show();
        }
    });

    function onScrollFixedSidebarPluginOption() {
        if (!($(".redux-sidebar").hasClass('redux-sidebar'))) return;
        if ($('.redux-sidebar').hasClass('no-fixed')) return;

        var top = $('.redux-sidebar').offset().top - parseFloat($('.redux-sidebar').css('marginTop').replace(/auto/, 0));
        var footTop = $('.redux-sidebar').next().next('.clear').offset().top - parseFloat($('.redux-sidebar').next().next('.clear').css('marginTop').replace(/auto/, 0));
        var maxY = footTop - $('.redux-sidebar').innerHeight();

        $(window).scroll(function (evt) {
            var y = $(this).scrollTop();
            if (y >= top) {
                if (y <= maxY) {
                    $('.redux-sidebar').addClass('fixed').removeAttr('style').css({
                        top: '32px',
                    });
                } else {
                    $('.redux-sidebar').removeClass('fixed').css({
                        position: 'absolute',
                        top: 'auto',
                        bottom: '0',
                        height: '100vh'
                    });
                }
            } else {
                $('.redux-sidebar').removeClass('fixed');
            }
        });
    }
    onScrollFixedSidebarPluginOption();

    function getModelsByMake() {
        var css_class_wrap = '.listing-select-meta-box-wrap';
        var $this = $(".tfcl-listing-make-admin-ajax", css_class_wrap);
        var modelSelectMetaBox = $(".tfcl-listing-model-admin-ajax", css_class_wrap);
        if ($this.length) {
            var selectedMake = $this.val();
            $.ajax({
                type: "POST",
                url: tfcl_main_vars.ajax_url,
                data: {
                    'action': 'get_model_by_make_ajax',
                    'make': selectedMake,
                    'type': 1,
                    'is_slug': '1'
                },
                success: function (res) {
                    modelSelectMetaBox.html(res);
                    var valSelected = modelSelectMetaBox.attr('data-selected');
                    if (typeof valSelected !== 'undefined') {
                        modelSelectMetaBox.val(valSelected);
                    }
                },
            });
        }
    }

    getModelsByMake();
    $(".tfcl-listing-make-admin-ajax").on('change', function () {
        getModelsByMake();
    });
});