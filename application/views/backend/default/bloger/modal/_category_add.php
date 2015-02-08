<div class="modal fade" id="category-add-modal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">

	<div class="modal-content box box-solid box-primary">

	    <div class="modal-header box-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title"><?= tr ( '_BACKEND_add_category_' ) ?></h3>
            </div>
	    <?= form_open ( 'backend/bloger/category-add', array( 'class' => 'form-horizontal form-ajax', 'id' => '_add_category_form', 'role' => 'form' ) ); ?>

	    <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label"><?= tr ( '_GLOBAL_name_' ); ?></label>
                    <div class="col-sm-10">
			<?=
			form_input ( array(
			    'type' => 'text',
			    'name' => 'name',
			    'value' => set_value ( 'name' ),
			    'id' => 'name',
			    'class' => 'form-control',
			    'required' => 'required',
			    'autofocus' => 'autofocus',
			    'maxlength' => '255',
			    'tabindex' => '1'
			) );
			?>
                    </div>
                </div>

		<?php $get_languages = get_languages ( TRUE ); ?>
		<div class="nav-tabs-custom">
		    <ul class="nav nav-tabs">
			<?php foreach ( $get_languages as $language ) : ?>
    			<li class="translations_<?= $language['code']; ?><?= ($language === reset ( $get_languages )) ? ' active' : ''; ?>"><a href="#translation-<?= $language['code']; ?>" data-toggle="tab"><?= $language['text']; ?></a></li>
			<?php endforeach; ?>
		    </ul>
		    <?php unset ( $language ); ?>

		    <div class="tab-content">
			<?php foreach ( $get_languages as $language ) : ?>
    			<div class="tab-pane translations_<?= $language['code']; ?><?= ($language === reset ( $get_languages )) ? ' active' : ''; ?>" id="translation-<?= $language['code']; ?>">
    			    <div class="m15">
				    <?=
				    form_input ( array(
					'type' => 'text',
					'name' => 'translation[' . $language['uID'] . ']',
					'value' => set_value ( 'translation[' . $language ['uID'] . ']' ),
					'id' => 'translation[' . $language['uID'] . ']',
					'class' => 'form-control',
					'maxlength' => '255',
					'placeholder' => tr ( '_GLOBAL_category_placeholder_' ),
					'required' => 'required',
					'tabindex' => '2'
				    ) );
				    ?>
    			    </div>
    			    <div class="clearfix"></div>

    			</div>
			<?php endforeach; ?>
		    </div>
		</div>

		<?php unset ( $language, $get_languages ); ?>

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

