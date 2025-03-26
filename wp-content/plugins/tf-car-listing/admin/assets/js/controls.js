jQuery(function ($) {
    sortableGalleryImages();
    checkboxToggle();
    colorPicker();
    togglePostFormatMetaBoxes();
    Metaboxes();
    checkShowHideControls('checkbox');
    onChangeShowHideControls('checkbox');
    checkShowHideControls('radio');
    onChangeShowHideControls('radio');
    attachmentFilePicker('.tfcl-options-control-attachments-control');
    ImagePicker('.tfcl-options-control-image-control');
    SingleImagePicker('.tfcl-options-control-single-image-control');
    addDynamicPanel();
    removeDynamicPanel();
    notRemoveFirstPanel();
    resetFormAfterSubmitTermMeta();
    onChangeSelectedDealer('tfcl-options-control-property_dealer_info');
    datePicker();

    function datePicker() {
        $("#tf-date-time").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
        });
    }

    function sortableGalleryImages() {
        $('#tfcl_listing_gallery_container').sortable({
            flow: 'horizontal',
            wrapPadding: [10, 10, 0, 0],
            elMargin: [0, 0, 10, 10],
            elHeight: 'auto',
            filter: function (index) { return index !== 2; },
            timeout: 1000,
            update: function (e, ui) {
                var data = [];
                $(".sortable_item").each(function (i, el) {
                    data.push($(el).data('data'));
                });
                $('.image-value').val(JSON.stringify(data));
            }
        }).disableSelection();
    }

    //Todo fix ().live isn't function
    jQuery.fn.extend({
        live: function (event, callback) {
            if (this.selector) {
                jQuery(document).on(event, this.selector, callback);
            }
            return this;
        }
    });

    // Add new dynamic panel
    function addDynamicPanel() {
        $('.dynamic-panel-button-add').on('click', function (event) {
            event.preventDefault();
            var controlId = $(this).attr('data-control-id');
            var latestFieldId = $(this).attr('data-id-field-latest');
            latestFieldId = parseInt(latestFieldId) + 1;
            $('#tfcl-options-control-' + controlId + ' .dynamic-panel-button-add').attr('data-id-field-latest', latestFieldId);

            var row = $('#tfcl-options-control-' + controlId + ' .wrapper-dynamic-panel-sample.empty-row.screen-reader-text').clone(true);
            row.removeClass('wrapper-dynamic-panel-sample empty-row screen-reader-text');
            row.addClass('wrapper-dynamic-panel');
            row.insertBefore('#tfcl-options-control-' + controlId + ' .container-dynamic-panel section:last');
            row.find('input').each(function (i, el) {
                if (el.hasAttribute('name')) {
                    var oldName = el.getAttribute('name');
                    var newName = oldName.replace(/\[-\d\]/, '[' + (latestFieldId) + ']');
                    el.setAttribute('name', newName);
                }
            });

            row.find('textarea').each(function (i, el) {
                if (el.hasAttribute('name')) {
                    var oldName = el.getAttribute('name');
                    var newName = oldName.replace(/\[-\d\]/, '[' + (latestFieldId) + ']');
                    el.setAttribute('name', newName);
                }
            });

            return false;
        });
    }

    // Remove dynamic panel
    function removeDynamicPanel() {
        $('.dynamic-panel-button-remove').on('click', function (event) {
            event.preventDefault();
            var controlId = $(this).attr('data-control-id');
            var latestFieldId = +$(this).closest('.tfcl-options-control-panel-dynamic').find('.dynamic-panel-button-add').attr('data-id-field-latest');
            latestFieldId = parseInt(latestFieldId) - 1;
            $('#tfcl-options-control-' + controlId + ' .dynamic-panel-button-add').attr('data-id-field-latest', latestFieldId);
            $(this).parent('.header-dynamic-panel').parent('section').remove();
            setTimeout(() => {
                $('#tfcl-options-control-' + controlId + ' section.wrapper-dynamic-panel').each(function (index, elm) {
                    $(elm).find('input').each(function (i, el) {
                        if (el.hasAttribute('name')) {
                            var oldName = el.getAttribute('name');
                            var newName = oldName.replace(/\[\d\]/, '[' + (index) + ']');
                            el.setAttribute('name', newName);
                        }
                    });

                    $(elm).find('textarea').each(function (i, el) {
                        if (el.hasAttribute('name')) {
                            var oldName = el.getAttribute('name');
                            var newName = oldName.replace(/\[\d\]/, '[' + (index) + ']');
                            el.setAttribute('name', newName);
                        }
                    });
                })
            }, 300);
            return false;
        });
    }

    // Handle first panel not remove
    function notRemoveFirstPanel() {
        $('.wrapper-dynamic-panel:first-child .header-dynamic-panel .dynamic-panel-button-remove').css('pointer-events', 'none');
    }

    /**
     * Show, hide a <div> based on a checkbox
     *
     * @return void
     * @since 1.0
     */
    function colorPicker() {
        if ($().wpColorPicker) {
            $('.tf-color-picker').wpColorPicker({
                change: function (event, ui) {
                    $(this).parents(".tfcl-options-control-inputs").find(".choose-color").trigger('change');
                }
            });
        }
    }

    function checkboxToggle() {
        $('body').on('change', '.checkbox-toggle input', function () {
            var $this = $(this),
                $toggle = $this.closest('.checkbox-toggle'),
                action;
            if (!$toggle.hasClass('reverse'))
                action = $this.is(':checked') ? 'slideDown' : 'slideUp';
            else
                action = $this.is(':checked') ? 'slideUp' : 'slideDown';

            $toggle.next()[action]();
        });
        $('.checkbox-toggle input').trigger('change');
    }

    function Metaboxes() {

        var args = { duration: 600 };
        $('.flat-toggle .toggle-title.active').siblings('.toggle-content').show();

        $('.flat-toggle.enable .toggle-title').on('click', function () {
            $(this).closest('.flat-toggle').find('.toggle-content').slideToggle(args);
            $(this).toggleClass('active');
        }); // toggle 

        $('.tfcl-accordion .toggle-title').on('click', function () {
            if (!$(this).is('.active')) {
                $(this).closest('.tfcl-accordion').find('.toggle-title.active').toggleClass('active').next().slideToggle(args);
                $(this).toggleClass('active');
                $(this).next().slideToggle(args);
            } else {
                $(this).toggleClass('active');
                $(this).next().slideToggle(args);
            }
        });



    }

    function delFile($del_val, $array) {
        var returnedData = $.grep($array, function ($value) {
            return $value != $del_val;
        });
        return returnedData;
    }

    function attachmentFilePicker(element) {
        if ($(element).length != 0) {
            var frame,
                metaBox = $(element), // Your meta box id here
                addFileLink = metaBox.find('a.browse-media'),
                delFileLinks = metaBox.find('a.remove-all'),
                delFileLink = metaBox.find('a.tf-remove-media'),
                fileContainer = metaBox.find('.upload-preview'),
                fileIdInput = metaBox.find('.file-value');
            addFileLink.parent().show();
            var ids = [];

            // ADD IMAGE LINK
            addFileLink.on('click', function (event) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (frame) {
                    frame.open();
                    return;
                }

                // Create a new media frame
                frame = wp.media({
                    title: 'Select or Upload File',
                    button: {
                        text: 'Use this file'
                    },
                    multiple: true  // Set to true to allow multiple files to be selected
                });
                if (fileIdInput.val() != '') {
                    ids = JSON.parse(fileIdInput.val());
                }

                // When an image is selected in the media frame...
                frame.on('select', function () {

                    // Get media attachment details from the frame state
                    var length = frame.state().get('selection').length;

                    var files = frame.state().get("selection").models;

                    for (var iii = 0; iii < length; iii++) {
                        var file_name = files[iii].changed.filename;
                        var file_title = files[iii].changed.title;
                        var file_edit_link = files[iii].changed.editLink;
                        var file_mimetype = files[iii].changed.mime;
                        fileContainer.append('<li><a class="tf-file-title" href="' + file_edit_link + '" target="_blank"><span class="dashicons dashicons-media-default"></span></a><div class="tf-file-info"><a class="tf-file-title" href="' + file_edit_link + '" target="_blank">' + file_title + ' (' + file_mimetype + ')</a><div class="tf-file-name">' + file_name + '</div><a href="#" id="' + files[iii].id + '" class="button tf-remove-media" title="Remove">Remove</a></div>');

                        ids.push(files[iii].id);
                    }

                    // Hide the add image link

                    fileIdInput.val(JSON.stringify(ids));

                    // Unhide the remove image link
                    delFileLink.show();
                });

                // Finally, open the modal on click
                frame.open();
            });

            // Add more image 
            metaBox.on('click', 'a.tf-remove-media', function (event) {
                event.preventDefault();
                ids = JSON.parse(fileIdInput.val());
            })

            // DELETE IMAGE LINK
            metaBox.on('click', 'a.tf-remove-media', function (event) {
                event.preventDefault();
                ids = JSON.parse(fileIdInput.val());
                $(this).parent().parent().remove();
                ids = delFile($(this).attr('id'), ids);
                if (ids.length != 0) {
                    fileIdInput.val(JSON.stringify(ids));
                }
                else {
                    addFileLink.parent().show();
                    fileIdInput.val('');
                }
            });
            delFileLinks.on('click', function (event) {

                event.preventDefault();

                // Clear out the preview image
                fileContainer.html('');

                // Un-hide the add image link
                addFileLink.parent().show();

                // Hide the delete image link
                delFileLink.hide();

                // Delete the image id from the hidden input
                fileIdInput.val('');

            });
        }
    }

    function ImagePicker(element) {
        if ($(element).length != 0) {
            var frame,
                metaBox = $(element), // Your meta box id here
                addImgLink = metaBox.find('a.browse-media'),
                delImgLinks = metaBox.find('a.remove-all'),
                delImgLink = metaBox.find('a.tf-remove-media'),
                imgContainer = metaBox.find('.upload-preview'),
                imgIdInput = metaBox.find('.image-value');
            addImgLink.parent().show();
            var ids = [];

            // ADD IMAGE LINK
            addImgLink.on('click', function (event) {

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (frame) {
                    frame.open();
                    return;
                }

                // Create a new media frame
                frame = wp.media({
                    title: 'Select or Upload Media',
                    button: {
                        text: 'Use this media'
                    },
                    multiple: true  // Set to true to allow multiple files to be selected
                });
                if (imgIdInput.val() != '') {
                    ids = JSON.parse(imgIdInput.val());
                }

                // When an image is selected in the media frame...
                frame.on('select', function () {

                    // Get media attachment details from the frame state
                    var length = frame.state().get('selection').length;

                    var images = frame.state().get("selection").models;

                    for (var iii = 0; iii < length; iii++) {
                        var image_url = images[iii].changed.sizes.full.url;
                        imgContainer.append('<li class="sortable_item" data-data="' + images[iii].id + '"><img loading="lazy" src="' + image_url + '" alt="" style="max-width:100%;"/><a href="#" id="' + images[iii].id + '" class="tf-remove-media" title="Remove"> <span class="dashicons dashicons-no-alt"></span> </a>');
                        var image_caption = images[iii].changed.caption;
                        var image_title = images[iii].changed.title;
                        ids.push(images[iii].id);
                    }

                    // Hide the add image link

                    imgIdInput.val(JSON.stringify(ids));

                    // Unhide the remove image link
                    delImgLink.show();
                });

                // Finally, open the modal on click
                frame.open();
            });

            // Add more image 
            metaBox.on('click', 'a.tf-remove-media', function (event) {
                event.preventDefault();
                ids = JSON.parse(imgIdInput.val());
            })

            // DELETE IMAGE LINK
            metaBox.on('click', 'a.tf-remove-media', function (event) {
                event.preventDefault();
                ids = JSON.parse(imgIdInput.val());
                $(this).parent().remove();
                ids = delFile($(this).attr('id'), ids);
                if (ids.length != 0) {
                    imgIdInput.val(JSON.stringify(ids));
                }
                else {
                    addImgLink.parent().show();
                    imgIdInput.val('');
                }
            });
            delImgLinks.on('click', function (event) {

                event.preventDefault();

                // Clear out the preview image
                imgContainer.html('');

                // Un-hide the add image link
                addImgLink.parent().show();

                // Hide the delete image link
                delImgLink.hide();

                // Delete the image id from the hidden input
                imgIdInput.val('');

            });
        }
    }

    function SingleImagePicker(element) {
        if ($(element).length != 0) {
            var frame,
                metaBox = $(element), // Your meta box id here
                addImgLink = metaBox.find('a.browse-media'),
                delImgLink = $('a.tf-remove-media span');

            $('.tfcl-options-control').each(function () {
                if ($(this).find('.upload-preview li img').attr('src') === '') {
                    $(this).find('a.tf-remove-media span').parent().hide();
                }
            })

            // ADD IMAGE LINK
            addImgLink.on('click', function (event) {
                fieldId = $(event.target).data('id-field');
                var _root = $(this).parents('li');
                imgContainer = $("ul#" + fieldId + ".upload-preview"),
                    imgIdInput = _root.find('#' + fieldId + '.single-image-value');
                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (frame) {
                    frame.open();
                    return;
                }

                // Create a new media frame
                frame = wp.media({
                    title: 'Select or Upload Media',
                    button: {
                        text: 'Use this media'
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected in the media frame...
                frame.on('select', function () {

                    // Get media attachment details from the frame state
                    var length = frame.state().get('selection').length;
                    var images = frame.state().get("selection").models;
                    var image_url, image_id;
                    for (var iii = 0; iii < length; iii++) {
                        image_url = images[iii].changed.url;
                        imgContainer.html('');
                        imgContainer.append('<li><img loading="lazy" src="' + image_url + '" alt="" style="max-width:100%;"/><a href="#" id="' + images[iii].id + '" class="tf-remove-media" title="Remove"> <span data-id-field="' + fieldId + '" class="dashicons dashicons-no-alt"></span></a>');
                        image_id = images[iii].id;
                        var image_caption = images[iii].changed.caption;
                        var image_title = images[iii].changed.title;
                    }

                    // Hide the add image link
                    $(this).parent().hide();

                    imgIdInput.val(image_id);

                    // Unhide the remove image link
                    delImgLink.show();
                });

                // Finally, open the modal on click
                frame.open();
            });

            metaBox.on('click', 'a.tf-remove-media span', function (event) {
                event.preventDefault();
                var _root = $(this).parents('li');
                fieldId = $(event.target).data('id-field');
                imgIdInput = _root.find('#' + fieldId + '.single-image-value');
                imgIdInput.val('');
                $("ul#" + fieldId + ".upload-preview").html('');

            });

            $('form#addtag #submit').on('click', function () {
                setTimeout(() => {
                    $('.tfcl-options-control').each(function () {
                        $(this).find('.upload-preview li img').attr('src', '');
                        $(this).find('a.tf-remove-media span').parent().hide();
                        $(this).find('.single-image-value').val('');
                    })
                }, 1500);
            });
        }
    }

    function checkShowHideControls(typeControl) {
        $('.tfcl-options-container-content input[type=' + typeControl + ']').each(function () {
            var $this = $(this),
                childrenControl = $this.attr('children');
            if (childrenControl && childrenControl.length < 1) {
                return;
            }
            handleShowHideControls($this, typeControl);
        });

    }

    function onChangeShowHideControls(typeControl) {
        $(document).on('change', '.tfcl-options-container-content input[type=' + typeControl + ']', function () {
            var $this = $(this),
                childrenControl = $this.attr('children');
            if (childrenControl && childrenControl.length < 1) {
                return;
            }
            handleShowHideControls($this, typeControl);
            checkShowHideControls(typeControl);
        })
    }

    function handleShowHideControls(thisControl, typeControl) {
        var childrenControl = thisControl.attr('children');
        if (typeControl === 'checkbox' && $('#listing-detail').length) {
            if (thisControl.is(':checked')) {
                $(childrenControl).show('slow');
            }
            else {
                $(childrenControl).hide('slow');
            }
        }  
        else if (typeControl === 'checkbox') {
            if (!thisControl.is(':checked')) {
                $(childrenControl).hide('slow');
            }
            else {
                $(childrenControl).show('slow');
            }
        }
        else if (typeControl === 'radio') {
            if (thisControl.is(':checked')) {
                $(thisControl.attr('children')).show('slow');
            }
            else {
                $(childrenControl).hide('slow');
            }
        }
    }

    function resetFormAfterSubmitTermMeta() {
        $('form#addtag #submit').on('click', function () {
            setTimeout(() => {
                $('form#addtag').trigger("reset");
            }, 1500);
        });
    }

    function onChangeSelectedDealer(idControl) {
        $('#' + idControl + ' select').change(function () {
            let editButton = $('.edit-agent-button');
            let valueSelectAgent = $('#' + idControl + ' option:selected').val();
            if (valueSelectAgent !== '-1') {
                editButton.show('slow');
                var editLink = editButton.data('link');
                editLink = editLink.replace('post_id', valueSelectAgent);
                editButton.attr('href', editLink);
            }
            else {
                editButton.hide('slow')
            }
        });

        $('#' + idControl + ' select').trigger('change');
    }

    /**
     * Show, hide post format meta boxes
     *
     * @return void
     * @since 1.0
     */
    function togglePostFormatMetaBoxes() {
        var $input = $('input[name=post_format]'),
            $metaBoxes = $('#blog-options [id^="tfcl-options-control-"]').hide();

        // Don't show post format meta boxes for portfolio
        if ($('#post_type').val() == 'members')
            return;

        if ($('#post_type').val() == 'food')
            return;

        $input.change(function () {
            $metaBoxes.hide();
            if ($(this).val() == 'gallery' || $(this).val() == 'video') {
                $('[id*="tfcl-options-control-' + $(this).val() + '"]').show();
            }
            else $('#tfcl-options-control-blog_heading').show();

        });
        $input.filter(':checked').trigger('change');
    }

    var ImagePicker = (function () {
        function ImagePicker(element) {
            var self = this;

            this.root = $(element);
            this.settingLink = this.root.attr('data-customizer-link');
            this.settingMetaLink = this.root.attr('data-meta-link');
            this.idInput = $('input[data-listing="id"]', this.root);
            this.thumbnailInput = $('input[data-listing="thumbnail"]', this.root);
            this.preview = $('.upload-preview', this.root);
            this.selected = {
                id: this.idInput.val(),
                thumbnail: this.thumbnailInput.val()
            };

            $('a.browse-media', this.root).on('click', this.browse.bind(this));
            $('a.remove', this.root).on('click', this.remove.bind(this));

            this.thumbnailInput.on('change', (function () {
                this.preview.empty();

                if (this.selected.thumbnail != '') {
                    this.root.addClass('has-image');
                    this.preview.append($('<img loading="lazy" />', { src: this.selected.thumbnail }));
                }
                else {
                    this.root.removeClass('has-image');
                }

            }).bind(this)).trigger('change');
        };

        ImagePicker.prototype = {
            initUploader: function () {
                var self = this;
                var root = this.root;

                // Initialize the drag to upload plugin
                new wp.Uploader($.extend({
                    container: root,
                    browser: root.find('.upload'),
                    dropzone: root.find('.upload-dropzone'),
                    success: function (attachment) {
                        root.removeClass('has-error');
                        self.select(attachment);
                    },
                    error: function (message) {
                        root.addClass('has-error');
                        root.find('.tfcl-options-control-message').remove();
                        root.find('.tfcl-options-control-inputs').append(
                            $('<p />', { 'class': 'tfcl-options-control-message tfcl-options-control-error' }).text(message)
                        );
                    },
                    progress: function (attachment) { },
                    plupload: {},
                    params: {}
                }, {}));
            },

            browse: function (e) {
                var self = this, mediaManager;

                e.preventDefault();

                // Create media manager instance
                mediaManager = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: { text: 'Choose Image' },
                    multiple: true,
                    library: { type: 'image' }
                });

                // Register select event to update value
                mediaManager.on('select', function () {
                    var
                        attachment = mediaManager.state().get('selection').first();
                    self.select(attachment);
                });

                mediaManager.open();
            },

            select: function (attachment) {
                var thumbnail = {};

                // Find the smallest thumbnail
                $.map(attachment.get('sizes'), function (value) {
                    if (thumbnail.width === undefined || thumbnail.width > value.width)
                        thumbnail = value;
                });

                this.selected = { id: attachment.get('id'), thumbnail: thumbnail.url };
                this.idInput.val(this.selected.id).trigger('change');
                this.thumbnailInput.val(this.selected.thumbnail).trigger('change');
            },

            remove: function (e) {
                e.preventDefault();

                this.selected = { id: '', thumbnail: '' };
                this.idInput.val('').trigger('change');
                this.thumbnailInput.val('').trigger('change');
            }
        };

        return ImagePicker;
    })();
});