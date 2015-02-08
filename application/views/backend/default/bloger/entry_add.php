<div class="page-header page-header-block">
    <div class="page-header-section">
        <h4 class="title semibold"><?= tr ( '_MENU_LINK_blog_' ); ?></h4>
    </div>
    <div class="page-header-section">
        <div class="toolbar">
            <a href="<?= backend_url ( array( 'bloger' ) ); ?>" class="btn btn-danger">
                <i class="ico-arrow-left"></i> <?= tr ( '_BACKEND_go_back_' ); ?>
            </a>
        </div>
    </div>
</div>

<div class="row">

    <?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => 'blog_add_form', 'role' => 'form' ) ); ?>

    <div class="col-lg-12">

        <div class="panel">

            <div class="panel-body pt0 pb0">

                <div class="form-group header bgcolor-default">
                    <div class="col-md-12">
                        <h4 class="semibold text-primary mt0 mb5"><?= tr ( '_GLOBAL_blog_info_' ); ?></h4>
                        <p class="text-default nm"><?= tr ( '_GLOBAL_blog_info_help_' ); ?></p>
                    </div>
                </div>

                <div class="form-group" >
                    <label for="status_id" class="col-sm-2 control-label"><?= tr ( '_GLOBAL_status_' ); ?></label>

                    <div class="col-sm-5">
                        <select name="status_id" id="status_id" class="form-control" autofocus="autofocus" tabindex="1">
                            <option value=""><?= tr ( '_GLOBAL_FORMS_select_one_option_' ); ?></option>
                            <option value="0"><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                            <option value="1"><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group" >
                    <label for="category_id" class="col-sm-2 control-label"><?= tr ( '_GLOBAL_category_' ); ?></label>

                    <div class="col-sm-5">
                        <select name="category_id" id="category_id" class="form-control" tabindex="2">
                            <option value=""><?= tr ( '_GLOBAL_FORMS_select_one_option_' ); ?></option>
			    <?php foreach ( $data['categories'] AS $category ) : ?>
    			    <option value="<?= $category['id']; ?>" ><?= $category['text']; ?></option>
			    <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label"><?= tr ( '_GLOBAL_client_image_' ); ?></label>
                    <div class="col-sm-10">
                        <div class="btn-group pr5">

                        </div>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 300px; height: 200px;">
                                <img src="<?= $this->template->thumb ( 'img', '_blog/placeholder.jpg', array( 'w' => 300, 'h' => 200, 'type' => 'resize' ) ) ?>" alt="blog_image">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 300px; height: 200px;"></div>
                            <div>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new"><?= tr ( '_GLOBAL_change_' ); ?></span>
                                    <span class="fileinput-exists"><?= tr ( '_GLOBAL_change_' ); ?></span>

                                    <input type="file" name="image">
                                </span>
                            </div>
                        </div>

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
					form_input ( array(
					    'type' => 'text',
					    'name' => 'translations[' . $language['uID'] . '][title]',
					    'value' => set_value ( 'translations[' . $language['uID'] . '][title]' ),
					    'id' => 'translations[' . $language['uID'] . '][title]',
					    'class' => 'form-control',
					    'required' => 'required',
					    'tabindex' => 3
					) );
					?>
    				</div>
    				<div class="clearfix"></div>
    			    </div>
    			</div>

    			<div class="form-horizontal">
    			    <div class="form-group">
    				<label class="control-label col-sm-2"><?= tr ( '_GLOBAL_description_' ); ?></label>
    				<div class="col-sm-10">
					<?=
					form_textarea ( array(
					    'name' => 'translations[' . $language['uID'] . '][text]',
					    'value' => set_value ( 'translations[' . $language['uID'] . '][text]' ),
					    'id' => 'translations[' . $language['uID'] . '][text]',
					    'class' => 'form-control editor-wyswyg',
					    'tabindex' => 4
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
    <?php unset ( $language, $get_languages ); ?>
</div>