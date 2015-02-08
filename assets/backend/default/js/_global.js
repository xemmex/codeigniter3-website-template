/*
 * main.js
 */
jQuery(document).ready(function ($) {

    /*
     /*	Ready Function
     /*
     /*  Rev:  1.0
     */

    // Realod Page
    $('.reload-page').on('click', function (e) {
        $("body").fadeOut("slow", function () {
            window.location.reload();
        });
        e.preventDefault();
    });

    // Keys Help
    if ($('abbr[title]').length > 0) {
        //  $('abbr[title]').tooltip();
    }

    // Autofocus on Modal
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('[autofocus]').focus();
    });

    // Custom Selects
    load_select();

    // Coordinates MAP
    if ($('input.latitude').length > 0 && $('input.longitude').length > 0) {

        var map_lat = $("input[map-type='latitude']");
        var map_lng = $("input[map-type='longitude']");
        var map_id = map_lat.attr('map-id');
        var map_address = $('#' + map_lat.attr('map-address'));
        var map_position = new google.maps.LatLng(map_lat.val(), map_lng.val());
        var map_options = {
            center: map_position,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById(map_id), map_options);
        var map_geocoder = new google.maps.Geocoder();
        var map_marker = new google.maps.Marker({
            position: map_position,
            map: map,
            draggable: true
        });
        // Events
        google.maps.event.addListener(map, 'click', function (event) {
            map_marker.setPosition(event.latLng);
            map_lat.val(map_marker.getPosition().lat());
            map_lng.val(map_marker.getPosition().lng());
        });
        google.maps.event.addListener(map_marker, 'dragend', function () {
            map_lat.val(this.getPosition().lat());
            map_lng.val(this.getPosition().lng());
        });
        map_address.on('change', function () {
            map_address_find();
            return false;
        });
        map_address.on('keypress', function (event) {
            if (event.keyCode === 10 || event.keyCode === 13) {
                event.preventDefault();
                map_address_find();
            }
        });
        // Functions
        function map_address_find() {

            var map_address_help = map_address.next('.help-block');
            var map_address_val = map_address.val();
            map_geocoder.geocode({'address': map_address_val}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map_lat.val(results[0].geometry.location.lat());
                    map_lng.val(results[0].geometry.location.lng());
                    map_address_help.removeClass().addClass('alert help-block alert-success mb0').html(map_address_help.attr('data-find-success'));
                    map_marker.setPosition(results[0].geometry.location);
                    map.setZoom(16);
                } else {
                    map_address_help.removeClass().addClass('alert help-block alert-danger mb0').html(map_address_help.attr('data-find-error'));
                }
            });
        }
    }

    // Sortable Elements
    if ($('.table-sortable').length > 0) {
        $('.table-sortable').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>',
            handle: '.btn-sortable',
            onDrop: function (item, container, _super) {
                var positions = $('.table-sortable').sortable("serialize").get();
                var data = JSON.stringify(positions, null, ' ');
                send_ajax_data($('.table-sortable').attr('data-url'), data);
                _super(item, container);
            }
        });
    }

    // Datatables Elements
    if ($('.table-datatables').length > 0) {
        $('.table-datatables').dataTable();
        $('body').on("keyup", ".dataTables_filter input", function (e) {
            $('.table-datatables td').removeHighlight();
            if ($('.dataTables_filter input').val() !== "") {
                $('.table-datatables td').highlight($('.dataTables_filter input').val());
            }
        });
    }

    // Datatables Elements -  SERVER SIDE
    if ($('.table-datatables-server').length > 0) {
        var table = $('.table-datatables-server');
        table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": table.attr('data-url'),
                "type": "POST"
            }
        });
    }

    // Text Editor - SUMMENOTE
    if ($('.editor-wyswyg').length > 0) {
        load_editor();
    }

    // Change Single Value
    if ($('.change-value').length > 0) {
        $('.change-value').each(function () {
            var element = $(this);
            element.editable({
                container: 'body',
                mode: element.attr('data-editable-mode'),
                pk: element.attr('data-editable-pk'),
                url: element.attr('data-editable-url'),
                title: element.attr('data-editable-title'),
                params: {
                    table: element.attr('data-editable-table'),
                    column: element.attr('data-editable-column'),
                    rules: element.attr('data-editable-rules')
                },
                success: function (response) {
                    if (response.status === false) {
                        show_growl(response.message, "danger");
                    }
                    else {
                        show_growl(response.message, "success");
                    }
                }
            });
            delete element;
        });
    }

    // Change List Value
    if ($('.change-list').length > 0) {
        $('.change-list').each(function () {
            var element = $(this);
            element.editable({
                container: 'body',
                source: element.attr('data-editable-source'),
                mode: element.attr('data-editable-mode'),
                type: element.attr('data-editable-type'),
                pk: element.attr('data-editable-pk'),
                url: element.attr('data-editable-url'),
                title: element.attr('data-editable-title'),
                params: {
                    table: element.attr('data-editable-table'),
                    column: element.attr('data-editable-column'),
                    rules: element.attr('data-editable-rules')
                },
                success: function (response) {
                    if (response.status === false) {
                        show_growl(response.message, "danger");
                    }
                    else {
                        show_growl(response.message, "success");
                    }
                },
                display: function (value, sourceData) {
                    var html = [], checked = $.fn.editableutils.itemsByValue(value, sourceData);
                    if (checked.length) {

                        $.each(checked, function (i, v) {
                            html.push('<span class="label label-' + element.attr('data-editable-class') + '">' + v.text + '</span>');
                        });
                        $(this).html(html.join('<br>'));
                    } else {
                        $(this).empty();
                    }
                }
            });
            delete element;
        });
    }

    // Change Default
    $('body').on("click", ".change-default", function (e) {
        change_default($(this), $('.change-default'));
        e.preventDefault();
    });

    // Change Status
    $('body').on("click", ".change-status", function (e) {
        change_status($(this));
        e.preventDefault();
    });

    // Info AJAX Call
    $('body').on("click", ".info-ajax", function (e) {
        var element = $(this);
        jQuery.ajax({
            type: "POST",
            url: element.attr('data-url')
        }).done(function (response) {
            bootbox.dialog({
                message: response,
                title: element.attr('data-title'),
                buttons: {
                    success: {
                        label: "OK",
                        className: "btn-primary"
                    }
                }
            });
        });
        e.preventDefault();
    });

    // Prompt AJAX Call
    $('body').on("click", ".prompt-ajax", function (e) {
        var element = $(this);
        bootbox.prompt(element.attr('data-message'), function (data) {
            if (data !== null) {
                send_ajax_data(element.attr('data-url'), data);
            }
        });
        e.preventDefault();
    });

    // Modal AJAX Call
    $('body').on("click", ".modal-ajax", function (e) {
        var element = $(this);
        $.ajax({
            type: "POST",
            url: element.attr('data-url')
        }
        ).done(function (response) {
            $('section.content').append(response);
            $(element.attr('data-modal-id')).modal('show');
            load_editor();
            load_select();

        });

        e.preventDefault();
    });

    // Dialog AJAX Call
    $('body').on("click", ".dialog-ajax", function (e) {
        var element = $(this);
        bootbox.dialog({
            message: element.attr('data-message'),
            title: element.attr('data-title'),
            buttons: {
                confirm: {
                    label: element.attr('data-confirm-label'),
                    className: "btn-success",
                    callback: function () {
                        send_ajax_element(element);
                    }
                },
                cancel: {
                    label: element.attr('data-cancel-label'),
                    className: "btn-danger"
                }
            }
        });
        e.preventDefault();
    });

    // Dialog PREVIEW Call
    $('body').on("click", ".dialog-preview", function (e) {

        var element = $(this);

        if (element.attr('data-img-url')) {
            var img = $('<img class="img-reponsive">');
            img.attr('src', $(this).attr('data-img-url'));
        }

        bootbox.dialog({
            message: img,
            title: element.attr('data-title'),
            size: element.attr('data-size')
        });
        e.preventDefault();
    });

    // Global Forms
    $('body').on('submit', 'form:not(.form-search)', function (e) {
        var form = $(this);
        if (form.hasClass('form-ajax'))
        {
            e.preventDefault();
            var ladda = Ladda.create(form.find(':submit').get(0));
            ladda.start();
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function () {
                    ladda.start();
                },
                success: function (response) {
                    if (response.csrf) {
                        $.each(response.csrf, function (name, value) {
                            $(':input[name="' + name + '"]').val(value);
                        });
                    }
                    if (response.rules) {
                        $.each(response.rules, function (name, classes) {
                            form.find(':input[name="' + name + '"]').closest('.form-group').removeClass().addClass('form-group ' + classes);
                        });
                    }
                    if (response.redraw) {
                        $('.table-datatables-server').DataTable().draw();
                    }
                    if (response.shuffle_id) {
                        $('.shuffle').find('#element-' + response.shuffle_id).attr('data-categories', response.shuffle_value);
                    }
                    if (response.status === false && response.message) {
                        show_growl(response.message, "danger");
                    }
                    else
                    if (response.status === true && response.reload) {
                        jQuery("body").fadeOut("slow", function () {
                            window.location.reload();
                        });
                    }
                    else
                    if (response.status === true && response.redirect) {
                        $("body").fadeOut("slow", function () {
                            window.location.replace(response.redirect);
                        });
                    }
                    else
                    if (response.status === true && response.message) {
                        show_growl(response.message, "success");
                        form.find(':input').closest('.form-group').removeClass().addClass('form-group');
                    }
                    else
                    {
                        form.children('.panel-body').children('.panel-alert').removeClass('hidden alert-success').addClass('alert-danger').hide().fadeIn();
                        form.children('.panel-body').children('.panel-alert').children('.form_error').html(response);
                    }
                    ladda.stop();
                },
                error: function (response) {
                    if (response.csrf) {
                        $.each(response.csrf, function (name, value) {
                            $(':input[name="' + name + '"]').val(value);
                        });
                    }
                    if (response.rules) {
                        $.each(response.rules, function (name, classes) {
                            form.find(':input[name="' + name + '"]').closest('.form-group').removeClass().addClass('form-group ' + classes);
                        });
                    }
                    show_growl(response, "success");
                    form.children('.panel-body').children('.panel-alert').removeClass('hidden alert-danger').addClass('alert-success');
                    form.children('.panel-body').children('.panel-alert').children('.form_error').html(response);
                    ladda.stop();
                }
            });
            return false;
        }
        else
        {
            form.find(':submit').prop('disabled', true);
        }

    });
});
function change_status(element) {
    jQuery.ajax({
        type: "POST",
        url: element.attr('data-url'),
        dataType: "json",
        data: {
            table: element.attr('data-table'),
            column: element.attr('data-column'),
            value: element.attr('data-value'),
            id: element.attr('data-id'),
            id_value: element.attr('data-id-value'),
            pk: element.attr('data-pk'),
            pk_value: element.attr('data-pk-value')
        }
    }
    ).done(function (response) {
        if (response.status === true && response.message) {

            if (element.attr('data-value') === '1') {
                element
                        .attr('data-value', '0')
                        .prop('title', element.attr('data-title-activate'))
                        .removeClass('btn-success')
                        .addClass('btn-danger')
                        .children('i')
                        .removeClass('glyphicon-ok')
                        .addClass('glyphicon-remove');
            }
            else
            if (element.attr('data-value') === '0') {
                {
                    element
                            .attr('data-value', '1')
                            .prop('title', element.attr('data-title-desactivate'))
                            .removeClass('btn-danger')
                            .addClass('btn-success')
                            .children('i')
                            .removeClass('glyphicon-remove')
                            .addClass('glyphicon-ok');
                }
            }
            show_growl(response.message, "success");
        }
        else
        if (response.status === false && response.message) {
            show_growl(response.message, "danger");
        }
        else
        if (response.message) {
            show_growl(response.message, "danger");
        }
    }
    );
}

function change_default(element, identifier) {
    jQuery.ajax({
        type: "POST",
        url: element.attr('data-url'),
        dataType: "json",
        data: {
            table: element.attr('data-table'),
            column: element.attr('data-column'),
            id: element.attr('data-id'),
            id_value: element.attr('data-id-value')
        }
    }
    ).done(function (response) {
        if (response.status === true && response.message) {

            identifier
                    .prop('disabled', false)
                    .prop('title', element.attr('data-title-default-no'))
                    .removeClass('btn-info')
                    .addClass('btn-default')
                    .children('i')
                    .removeClass('glyphicon-ok')
                    .addClass('glyphicon-minus');
            element
                    .prop('disabled', true)
                    .prop('title', element.attr('data-title-default-yes'))
                    .removeClass('btn-default')
                    .addClass('btn-info')
                    .children('i')
                    .removeClass('glyphicon-minus')
                    .addClass('glyphicon-ok');
            show_growl(response.message, "success");
        }
        else
        if (response.status === false && response.message) {
            show_growl(response.message, "danger");
        }
        else
        if (response.message) {
            show_growl(response.message, "danger");
        }
    });
}

function show_growl(message, type) {
    jQuery.growl(message, {
        type: type,
        allow_dismiss: false,
        z_index: 9999,
        placement: {
            from: 'bottom',
            align: 'right'
        }
    });
}
function send_ajax_element(element) {
    jQuery.ajax({
        type: "POST",
        url: element.attr('data-url'),
        dataType: "json"
    }
    ).done(function (response) {
        if (response.status === true) {
            if (response.reload) {
                jQuery("body").fadeOut("slow", function () {
                    window.location.reload();
                });
            }
            if (response.redirect) {
                jQuery("body").fadeOut("slow", function () {
                    window.location.replace(response.redirect);
                });
            }
            if (element.attr('data-delete-editor')) {
                delete_editor(element);
            }
            if (element.attr('data-delete-element')) {
                jQuery(element.attr('data-delete-element')).remove();
                element.closest(element.attr('data-delete-closet')).remove();
            }
            if (element.attr('data-delete-closet')) {
                element.closest(element.attr('data-delete-closet')).remove();
            }
            if (element.attr('data-delete-datatables')) {
                var delete_row = element.parents('tr');
                var delete_table = delete_row.parents('table');
                delete_table.DataTable().row(delete_row).remove().draw();
                delete delete_row;
                delete delete_table;
            }
            if (element.attr('data-delete-single-row')) {
                jQuery('#' + element.attr('data-delete-single-row')).remove();
            }
            if (element.attr('data-delete-shuffle-element')) {
                var $items = $(element.attr('data-delete-shuffle-element'));
                jQuery(element.attr('data-delete-shuffle-container')).shuffle('remove', $items);
            }
            if (response.message) {
                show_growl(response.message, "success");
            }
        }
        else
        if (response.message) {
            show_growl(response.message, "danger");
        }
    }
    ).always(function (response) {
        if (response.csrf) {
            jQuery.each(response.csrf, function (name, value) {
                jQuery(':input[name="' + name + '"]').val(value);
            });
        }
    });
}

function send_ajax_data(url, data) {
    jQuery.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: {
            data: data
        }
    }
    ).done(function (response) {
        if (response.csrf) {
            jQuery.each(response.csrf, function (name, value) {
                jQuery(':input[name="' + name + '"]').val(value);
            });
        }
        if (response.reload) {
            jQuery("body").fadeOut("slow", function () {
                window.location.reload();
            });
        }
        if (response.redirect) {
            jQuery("body").fadeOut("slow", function () {
                window.location.replace(response.redirect);
            });
        }
        else
        if (response.status === true && response.message) {
            show_growl(response.message, "success");
        }
        else
        if (response.status === false && response.message) {
            show_growl(response.message, "danger");
        }
        else
        if (response.message) {
            show_growl(response.message, "danger");
        }
    }
    ).always(function (response) {
        if (response.csrf) {
            jQuery.each(response.csrf, function (name, value) {
                jQuery(':input[name="' + name + '"]').val(value);
            });
        }
    });
}


function load_select() {
    if (jQuery('select.selectize').length > 0) {
        jQuery('select.selectize').selectize();
    }
}

function load_editor() {
    if (jQuery('.editor-wyswyg').length > 0) {
        load_editor_ckeditor();
    }
}

function delete_editor(element) {
    delete_editor_ckeditor(element);
}

function delete_editor_ckeditor(element) {
    var ckeditor = CKEDITOR.instances[element.attr('data-delete-editor')];
    CKEDITOR.remove(ckeditor);
}

function load_editor_ckeditor() {
    jQuery('.editor-wyswyg').ckeditor();
}

function load_editor_wyswyg() {
    jQuery('.editor-wyswyg').wysihtml5();
}

function load_editor_tinymce() {
    tinymce.init({
        selector: '.editor-wyswyg',
        height: 300,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ]

    });
}

function load_editor_summernote() {
    jQuery('.editor-wyswyg').summernote({
        height: 300,
        focus: true,
        enterHtml: '',
        emptyPara: '',
        blankHTML: '',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height', 'table', 'hr']],
            ['insert', ['picture', 'link', 'video']],
            // ['misc', ['fullscreen', 'codeview']]
            ['misc', ['codeview']]
        ],
        onenter: function (event) {
            document.execCommand('insertHTML', false, '<br>');
            return false;
        }
    });
}