/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    config.toolbarGroups = [
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
        {name: 'links'},
        {name: 'insert'},
        {name: 'tools'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align']},
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        '/',
        {name: 'styles'},
        {name: 'colors'}


    ];

    // Skin
    // config.skin = 'bootstrapck';

    // Format
    config.format_div = {element: 'div', attributes: {'data-no-turbolink': 'true'}};

    // Remove some buttons, provided by the standard plugins, which we don't
    // need to have in the Standard(s) toolbar.
    config.removeButtons = 'Underline,Subscript,Superscript';

    // Se the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre';

    // Make dialogs simpler.
    config.removeDialogTabs = 'image:advanced;link:advanced';

    // Remove P from start TAG
    config.enterMode = CKEDITOR.ENTER_BR;
    config.shiftEnterMode = CKEDITOR.ENTER_P;

    // Allow Extra Content in Advanded Filter
    config.extraAllowedContent = '*{*}';

    // Toolbar
    config.toolbarCanCollapse = true;
    config.toolbarStartupExpanded = false;

    // KC Finder
    config.filebrowserBrowseUrl = assets + 'plugins/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = assets + 'plugins/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = assets + 'plugins/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = assets + 'plugins/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = assets + 'plugins/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl = assets + 'plugins/kcfinder/upload.php?type=flash';

    // Editor Height
    config.extraPlugins = 'youtube,autogrow';
    config.autoGrow_onStartup = true;
};

CKEDITOR.config.allowedContent = true;
CKEDITOR.timestamp = '20141113';
