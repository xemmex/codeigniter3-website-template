<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><?= tr ( '_BACKEND_configure_categories_' ); ?></h4>
    </div>
    <div class="page-header-section">
        <div class="toolbar">
            <a href="<?= backend_url ( array ( 'bloger', 'categories' ) ); ?>" class="btn btn-danger">
                <i class="ico-arrow-left"></i> <?= tr ( '_BACKEND_go_back_' ); ?>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <?= form_open ( NULL, array ( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => 'categories_edit_form', 'role' => 'form' ) ); ?>
    <div class="col-lg-12">
        <div class="panel">

            <div class="panel-body pt0 pb0">

                <div class="form-group header bgcolor-default">
                    <div class="col-md-12">
                        <h4 class="semibold text-primary mt0 mb5"><?= tr ( '_GLOBAL_category_info_' ); ?></h4>
                        <p class="text-default nm"><?= tr ( '_GLOBAL_category_info_help_' ); ?></p>
                    </div>
                </div>


                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label"><?= tr ( '_GLOBAL_name_' ); ?></label>
                    <div class="col-sm-8">
                        <?=
                        form_input ( array (
                            'type' => 'text',
                            'name' => 'name',
                            'value' => set_value ( 'name', $data['text'] ),
                            'id' => 'name',
                            'class' => 'form-control',
                            'required' => 'required',
                            'autofocus' => 'autofocus',
                            'maxlength' => '255'
                        ) );
                        ?>
                    </div>
                </div>

                <?php $get_languages = get_languages ( TRUE ); ?>

                <ul class="nav nav-tabs">
                    <?php foreach ( $get_languages as $language ) : ?>
                        <li class="translations_<?= $language['code']; ?><?= ($language['uID'] == current_language ( 'uID' )) ? ' active' : ''; ?>"><a href="#translation-<?= $language['code']; ?>" data-toggle="tab"><?= $language['text']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content panel">
                    <?php foreach ( $get_languages as $language ) : ?>
                        <div class="tab-pane translations_<?= $language['code']; ?><?= ($language['uID'] == current_language ( 'uID' )) ? ' active' : ''; ?>" id="translation-<?= $language['code']; ?>">

                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-2"><?= tr ( '_GLOBAL_name_' ); ?></label>
                                    <div class="col-sm-10">
                                        <?=
                                        form_input ( array (
                                            'type' => 'text',
                                            'name' => 'translation[' . $language['uID'] . ']',
                                            'value' => set_value ( 'translation[' . $language ['uID'] . ']', $data['translations'][$language['uID']]['text'] ),
                                            'id' => 'translation[' . $language['uID'] . ']',
                                            'class' => 'form-control',
                                            'maxlength' => '255',
                                            'placeholder' => tr ( '_GLOBAL_category_placeholder_' ),
                                            'required' => 'required'
                                        ) );
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>


                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary ladda-button" data-style="expand-left">
                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                </button>
            </div>
        </div>
    </div>
    <?= form_close (); ?>
</div>