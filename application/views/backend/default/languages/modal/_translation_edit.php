<div class="modal fade" id="translation-edit-<?= $data['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content box box-solid box-primary">

            <div class="modal-header box-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title"><?= tr ( '_BACKEND_edit_translation_' ) ?></h3>
            </div>

	    <?= form_open ( NULL, array( 'class' => 'form-horizontal form-ajax', 'id' => 'translation_edit_form' . $data['id'], 'role' => 'form' ) ); ?>
	    <?= form_hidden ( 'ajax_submit', TRUE ); ?>

	    <div class="modal-body">
		<div class="form-horizontal">
		    <div class="form-group">
			<label class="control-label col-sm-2"><?= tr ( '_GLOBAL_translation_key_' ); ?></label>
			<div class="col-sm-10">
			    <?=
			    form_input ( array(
				'type' => 'text',
				'name' => 'key',
				'value' => set_value ( 'key', $data['key'] ),
				'id' => 'key',
				'class' => 'form-control',
				'required' => 'required',
				'autofocus' => 'autofocus'
			    ) );
			    ?>
			</div>
			<div class="clearfix"></div>
		    </div>
		</div>

		<div class="nav-tabs-custom">
		    <ul class="nav nav-tabs">
			<?php foreach ( get_languages ( TRUE ) as $language ) : ?>
    			<li<?= (isset ( $data['language_id'] ) && $data['language_id'] == $language['uID']) ? ' class="active"' : ''; ?>><a href="#translation-edit-<?= $data['id']; ?>-<?= $language['code']; ?>" data-toggle="tab"><?= $language['text']; ?></a></li>
			<?php endforeach; ?>
		    </ul>
		    <div class="tab-content">
			<?php foreach ( get_languages ( TRUE ) as $language ) : ?>
    			<div class="tab-pane<?= (isset ( $data['language_id'] ) && $data['language_id'] == $language['uID']) ? ' active' : ''; ?>" id="translation-edit-<?= $data['id']; ?>-<?= $language['code']; ?>">
				<?=
				form_textarea ( array(
				    'name' => 'translations[' . $data['translations'][$language['uID']]['id'] . ']',
				    'value' => set_value ( 'translations[' . $data['translations'][$language['uID']]['id'] . ']', $data['translations'][$language['uID']]['text'] ),
				    'id' => 'translations[' . $data['translations'][$language['uID']]['id'] . ']',
				    'class' => 'form-control editor-wyswyg'
				) );
				?>
    			</div>
			<?php endforeach; ?>
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

