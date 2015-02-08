jQuery(document).ready(function($) {

    // Email Protoclo
    _mail_protocol_();

    _system_image_watermark_status_();

    _user_register_enabled_();

    $("#_mail_protocol_").on('change', function() {
        _mail_protocol_();
    });

    $("#_system_image_watermark_status_").on('change', function() {
        _system_image_watermark_status_();
    });

    $("#_user_register_enabled_").on('change', function() {
        _user_register_enabled_();
    });

});

function _mail_protocol_() {
    if ($("#_mail_protocol_").val() === 'smtp') {
        jQuery("[data-parent='_mail_protocol_'] ").fadeIn();
    }
    else {
        jQuery("[data-parent='_mail_protocol_'] ").hide();
    }
}

function _system_image_watermark_status_() {
    if ($("#_system_image_watermark_status_").val() === '1') {
        jQuery("[data-parent='_system_image_watermark_status_'] ").fadeIn();
    }
    else {
        jQuery("[data-parent='_system_image_watermark_status_'] ").hide();
    }
}

function _user_register_enabled_() {
    if ($("#_user_register_enabled_").val() === '1') {
        jQuery("[data-parent='_user_register_enabled_'] ").fadeIn();
    }
    else {
        jQuery("[data-parent='_user_register_enabled_'] ").hide();
    }
}

