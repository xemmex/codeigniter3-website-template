<div class="modal fade" id="translation-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content box box-solid box-primary">

            <div class="modal-header box-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title"><?= tr ( '_BACKEND_add_translation_' ) ?></h3>
            </div>

	    <?= form_open ( 'backend/languages/translation-add', array( 'class' => 'form-horizontal form-ajax', 'id' => '_add_translation_form', 'role' => 'form' ) ); ?>

            <div class="modal-body">

                <div class="form-group">
                    <label for="key" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_translation_key_' ); ?></label>
                    <div class="col-sm-9">
			<?=
			form_input ( array(
			    'type' => 'text',
			    'name' => 'key',
			    'value' => set_value ( 'key' ),
			    'id' => 'key',
			    'class' => 'form-control',
			    'required' => 'required',
			    'autofocus' => 'autofocus',
			    'maxlength' => '255'
			) );
			?>
                    </div>
                </div>

		<?php $get_languages = get_languages ( TRUE ); ?>
		<div class="nav-tabs-custom">
		    <ul class="nav nav-tabs">
			<?php foreach ( $get_languages as $language ) : ?>
    			<li class="translations_<?= $language['code']; ?><?= ($language === reset ( $get_languages )) ? ' active' : ''; ?>"><a href="#translation-add-<?= $language['code']; ?>" data-toggle="tab"><?= $language['text']; ?></a></li>
			<?php endforeach; ?>
		    </ul>
		    <?php unset ( $language ); ?>

		    <div class="tab-content">
			<?php foreach ( $get_languages as $language ) : ?>
    			<div class="tab-pane translations_<?= $language['code']; ?><?= ($language === reset ( $get_languages )) ? ' active' : ''; ?>" id="translation-add-<?= $language['code']; ?>">
				<?=
				form_textarea ( array(
				    'name' => 'translation[' . $language['uID'] . ']',
				    'value' => set_value ( 'translation[' . $language ['uID'] . ']' ),
				    'id' => 'translation[' . $language['uID'] . ']',
				    'class' => 'form-control editor-wyswyg'
				) );
				?>
    			</div>
			<?php endforeach; ?>
		    </div>

		    <?php unset ( $language, $get_languages ); ?>
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

