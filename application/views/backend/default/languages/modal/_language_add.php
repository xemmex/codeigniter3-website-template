<div class="modal fade" id="language-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content box box-solid box-primary">

            <div class="modal-header box-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title"><?= tr ( '_BACKEND_add_language_' ) ?></h3>
            </div>

	    <?= form_open ( 'backend/languages/language-add', array( 'class' => 'form-horizontal form-ajax', 'id' => '_add_language_form', 'role' => 'form' ) ); ?>

            <div class="modal-body">

                <div class="form-group">
                    <label for="code" class="col-sm-5 control-label"><?= tr ( '_GLOBAL_language_code_' ); ?></label>
                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
			    <?=
			    form_input ( array(
				'type' => 'text',
				'name' => 'code',
				'value' => set_value ( 'code' ),
				'id' => 'code',
				'class' => 'form-control',
				'required' => 'required',
				'autofocus' => 'autofocus',
				'maxlength' => 2
			    ) );
			    ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="text" class="col-sm-5 control-label"><?= tr ( '_GLOBAL_name_' ); ?></label>
                    <div class="col-sm-7">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
			    <?=
			    form_input ( array(
				'type' => 'text',
				'name' => 'text',
				'value' => set_value ( 'text' ),
				'id' => 'text',
				'class' => 'form-control',
				'required' => 'required'
			    ) );
			    ?>
                        </div>
                    </div>
                </div>

                <div class="form-group" >
                    <label for="status" class="col-sm-5 control-label"><?= tr ( '_GLOBAL_status_' ); ?></label>

                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-question-sign"></span></span>
                            <select name="status" id="status" class="form-control">
                                <option value="0" <?= set_select ( 'status', '0' ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                <option value="1" <?= set_select ( 'status', '1' ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="form-group" >
                    <label for="translations" class="col-sm-5 control-label"><?= tr ( '_GLOBAL_copy_translation_' ); ?></label>

                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-question-sign"></span></span>
                            <select name="translations" id="translations" class="form-control">
				<?php foreach ( get_languages () as $language ) : ?>
    				<option value="<?= $language['uID']; ?>" class="translations_<?= $language['code']; ?>" <?= set_select ( 'translations', $language['uID'] ); ?> ><?= tr ( '_GLOBAL_yes_' ); ?> - <?= $language['text']; ?></option>
				<?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="form-group header hidden panel-alert">
                    <div class="col-md-12 form_error">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary ladda-button" data-style="expand-left">
                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_add_' ); ?></span>
                </button>
            </div>

	    <?= form_close (); ?>

        </div>
    </div>
</div>

