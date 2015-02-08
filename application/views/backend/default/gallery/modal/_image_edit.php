<div class="modal fade" id="image-edit-<?= $data['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content box box-solid box-primary">

            <div class="modal-header box-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title"><?= tr ( '_BACKEND_edit_image_' ) ?></h3>
            </div>

	    <?= form_open ( 'backend/gallery/image-edit/' . $data['id'], array( 'class' => 'form-horizontal form-ajax', 'id' => 'image_edit_form' . $data['id'], 'role' => 'form' ) ); ?>
	    <?= form_hidden ( 'ajax_submit', TRUE ); ?>

	    <div class="modal-body">
		<div class="form-horizontal">
		    <div class="form-group">
			<label class="control-label col-sm-2"><?= tr ( '_GLOBAL_categories_' ); ?></label>
			<div class="col-sm-10">
			    <?php $my_categories = explode ( ',', $data['gallery_id'] ); ?>
			    <select id="category" name="category[]" multiple="multiple" class="selectize">
				<option value=""><?= tr ( '_BACKEND_configure_categories_list_' ) ?></option>
				<?php foreach ( $categories as $category ) : ?>
    				<option value="<?= $category['id']; ?>"<?= in_array ( $category['id'], $my_categories ) ? ' selected="selected"' : ''; ?>><?= ucfirst ( $category['name'] ); ?></option>
				<?php endforeach; ?>
			    </select>
			    <?php unset ( $categories, $category, $categories ); ?>
			</div>
			<div class="clearfix"></div>
		    </div>
		</div>
		<?php $get_languages = get_languages ( TRUE ); ?>
		<div class="nav-tabs-custom">
		    <ul class="nav nav-tabs">
			<?php foreach ( $get_languages as $language ) : ?>
    			<li<?= ($language === reset ( $get_languages )) ? ' class="active"' : ''; ?>><a href="#image-edit-<?= $data['id']; ?>-<?= $language['code']; ?>" data-toggle="tab"><?= $language['text']; ?></a></li>
			<?php endforeach; ?>
		    </ul>
		    <div class="tab-content">
			<?php foreach ( $get_languages as $language ) : ?>
    			<div class="tab-pane<?= ($language === reset ( $get_languages )) ? ' active' : ''; ?>" id="image-edit-<?= $data['id']; ?>-<?= $language['code']; ?>">
    			    <div class="clearfix mb20"></div>
    			    <div class="form-horizontal">
    				<div class="form-group">
    				    <label class="control-label col-sm-2"><?= tr ( '_GLOBAL_title_' ); ?></label>
    				    <div class="col-sm-10">
					    <?=
					    form_input ( array(
						'name' => 'images[' . $language['uID'] . '][title]',
						'value' => set_value ( 'images[' . $language['uID'] . '][title]', $data['images'][$language['uID']]['title'] ),
						'id' => 'images[' . $language['uID'] . '][title]',
						'class' => 'form-control'
					    ) );
					    ?>

    				    </div>
    				    <div class="clearfix mb20"></div>
    				    <label class="control-label col-sm-2"><?= tr ( '_GLOBAL_text_' ); ?></label>
    				    <div class="col-sm-10">
					    <?=
					    form_textarea ( array(
						'name' => 'images[' . $language['uID'] . '][text]',
						'value' => set_value ( 'images[' . $language['uID'] . '][text]', $data['images'][$language['uID']]['text'] ),
						'id' => 'images[' . $language['uID'] . '][text]',
						'class' => 'form-control'
					    ) );
					    ?>

    				    </div>
    				    <div class="clearfix mb20"></div>
    				</div>
    			    </div>
    			</div>
			<?php endforeach; ?>
		    </div>
		</div>
		<?php unset ( $language, $get_languages ); ?>
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

