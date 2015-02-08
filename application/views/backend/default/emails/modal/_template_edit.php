<div class="modal fade" id="template-edit-<?= $data['id'] . $language['uID']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content box box-solid box-primary">

            <div class="modal-header box-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title"><?= tr ( '_BACKEND_edit_template_' ) ?></h3>
            </div>


	    <?= form_open ( NULL, array( 'class' => 'form-horizontal form-ajax', 'id' => 'template_edit_form', 'role' => 'form' ) ); ?>
	    <?= form_hidden ( 'ajax_submit', TRUE ); ?>
	    <div class="modal-body">

		<div class="form-group">
		    <label class="control-label col-sm-2"><?= tr ( '_GLOBAL_variables_' ); ?></label>
		    <div class="col-sm-10">
			<input class="form-control" readonly="readonly" value="<?= $data['variables']; ?>"/>
		    </div>
		    <div class="clearfix"></div>
		</div>

		<div class="nav-tabs-custom">
		    <?php $get_languages = get_languages ( TRUE ); ?>
		    <ul class="nav nav-tabs">
			<?php foreach ( $get_languages as $language ) : ?>
    			<li class="translations_<?= $language['code']; ?><?= ($language['uID'] == current_language ( 'uID' )) ? ' active' : ''; ?>"><a href="#template-edit-<?= $data['id']; ?>-<?= $language['code']; ?>" data-toggle="tab"><?= $language['text']; ?></a></li>
			<?php endforeach; ?>
		    </ul>
		    <?php unset ( $language ); ?>

		    <div class="tab-content">
			<?php foreach ( $get_languages as $language ) : ?>
    			<div class="tab-pane translations_<?= $language['code']; ?><?= ($language['uID'] == current_language ( 'uID' )) ? ' active' : ''; ?>" id="template-edit-<?= $data['id']; ?>-<?= $language['code']; ?>">

    			    <div class="form-horizontal mt10">
    				<label class="control-label col-sm-2"><?= tr ( '_GLOBAL_subject_' ); ?></label>
    				<div class="col-sm-10">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => 'templates[' . $language['uID'] . '][subject]',
					    'value' => set_value ( 'templates[' . $language['uID'] . '][subject]', $data['template'][$language['uID']]['subject'] ),
					    'id' => 'templates[' . $language['uID'] . '][subject]',
					    'class' => 'form-control',
					    'required' => 'required',
					    'autofocus' => 'autofocus'
					) );
					?>
    				</div>
    				<div class="clearfix"></div>
    			    </div>
    			    <div class="mt10">
				    <?=
				    form_textarea ( array(
					'name' => 'templates[' . $language['uID'] . '][message]',
					'value' => set_value ( 'templates[' . $language['uID'] . '][message]', $data['template'][$language['uID']]['message'] ),
					'id' => 'templates[' . $language['uID'] . '][message]',
					'class' => 'form-control editor-wyswyg'
				    ) );
				    ?>
    			    </div>

    			</div>

			<?php endforeach; ?>

			<?php unset ( $language, $get_languages ); ?>


		    </div>
		</div>

	    </div>

	    <div class="modal-footer">
                <button class="btn btn-primary ladda-button" data-style="expand-left">
                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                </button>
            </div>
	    <?= form_close (); ?>
        </div>
    </div>
</div>
