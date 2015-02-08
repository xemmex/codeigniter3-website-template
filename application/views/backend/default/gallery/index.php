<aside class="right-side">

    <section class="content-header">
        <h1><?= tr ( '_BACKEND_gallery_' ) ?></h1>
        <div class="pull-right toolbar">

	    <span class="btn btn-success fileinput-button">
		<i class="glyphicon glyphicon-plus"></i>
		<span><?= tr ( '_GLOBAL_add_image_' ); ?></span>
		<input id="add-images" type="file" name="image" multiple="multiple" data-url="<?= backend_url ( array( 'gallery', 'image-add' ) ); ?>">
	    </span>

	    <a href="<?= backend_url ( array( 'gallery', 'categories' ) ); ?>" class="btn btn-warning">
		<i class="fa fa-tags"></i> <?= tr ( '_BACKEND_categories_' ); ?>
	    </a>
        </div>
        <div class="clearfix"></div>

    </section>

    <section class="content">

	<div id="add-images-progress" class="progress" style="display: none;">
	    <div class="progress-bar progress-bar-success"></div>
	</div>

	<div class="row">
	    <div class="col-md-12" id="gallery-categories">
		<div class="btn-group" role="group">
		    <button class="btn btn-primary" data-category="all"><?= tr ( '_GLOBAL_all_' ) ?></button>
		</div>
		<div class="btn-group" role="group">
		    <button class="btn btn-danger" id="filter-no-category" data-category="0"><?= tr ( '_GLOBAL_no_category_' ) ?></button>
		</div>

		<div class="btn-group" role="group">
		    <?php foreach ( $data['categories'] as $category ) : ?>
    		    <button type="button" class="btn btn-warning" data-category="<?= $category['id']; ?>"><?= ucfirst ( $category['name'] ); ?></button>
		    <?php endforeach; ?>
		</div>

	    </div>
	</div>

	<div class="clearfix mb20"></div>

	<div class="row shuffle" id="gallery-container">
	    <?php foreach ( $data['gallery'] as $img ) : ?>
    	    <div class="item col-lg-2 col-md-2 col-xs-6" data-categories="<?= $img['gallery_id']; ?>" id="element-<?= $img['id']; ?>">
    		<div class="thumbnail">
    		    <div class="caption">
    			<div class="btn-container">
    			    <button
    				class="btn btn-sm btn-warning dialog-preview"
    				data-img-url="<?= $this->template->path ( 'uploads', $img['url'] ); ?>"
    				data-title="<?= tr ( '_GLOBAL_preview_' ) ?>"
    				data-size="large"
    				>
    				<i class="glyphicon glyphicon-eye-open"></i>
    			    </button>
				<?php if ( $img['status_id'] == 1 ): ?>
				    <button
					class="btn btn-sm btn-success change-status"
					data-url="<?= backend_url ( array( 'helper', 'change-status' ) ); ?>"
					data-table="galeria_images"
					data-column="uID_estados"
					data-value="<?= $img['status_id']; ?>"
					data-id="uID"
					data-id-value="<?= $img['id']; ?>"
					data-pk="uID"
					data-pk-value="<?= $img['id']; ?>"
					data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
					data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
					title="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
					>
					<i class="glyphicon glyphicon-ok"></i>
				    </button>
				<?php else : ?>
				    <button
					class="btn btn-sm btn-danger change-status"
					data-url="<?= backend_url ( array( 'helper', 'change-status' ) ); ?>"
					data-table="galeria_images"
					data-column="uID_estados"
					data-value="<?= $img['status_id']; ?>"
					data-id="uID"
					data-id-value="<?= $img['id']; ?>"
					data-pk="uID"
					data-pk-value="<?= $img['id']; ?>"
					data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
					data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
					title="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
					>
					<i class="glyphicon glyphicon-remove"></i>
				    </button>
				<?php endif; ?>
    			    <button
    				class="btn  btn-sm btn-primary modal-ajax"
    				data-url="<?= backend_url ( array( 'gallery', 'image-edit', $img['id'] ) ); ?>"
    				data-modal-id="#image-edit-<?= $img['id']; ?>"
    				title="<?= tr ( '_GLOBAL_edit_' ); ?>"
    				>
    				<i class="glyphicon glyphicon-edit"></i>
    			    </button>
    			    <button
    				class="btn btn-sm btn-danger dialog-ajax"
    				data-url="<?= backend_url ( array( 'gallery', 'image-delete', $img['id'] ) ); ?>"
    				data-message="<img src='<?= $this->template->thumb ( 'uploads', $img['url'], array( 'w' => 600, 'h' => 400, 'type' => 'stretch' ) ) ?>' class='img-responsive'>"
    				data-title="<?= tr ( '_GLOBAL_DIALOG_DELETE_GALLERY_IMAGE_title_' ) ?>"
    				data-confirm-label="<?= tr ( '_GLOBAL_confirm_' ) ?>"
    				data-cancel-label="<?= tr ( '_GLOBAL_cancel_' ) ?>"
    				data-delete-shuffle-container="#gallery-container"
    				data-delete-shuffle-element="#element-<?= $img['id'] ?>"
    				title="<?= tr ( '_GLOBAL_delete_' ); ?>"
    				>
    				<i class="glyphicon glyphicon-trash"></i>
    			    </button>
    			</div>
    		    </div>
    		    <img src="<?= $this->template->thumb ( 'uploads', $img['url'], array( 'w' => 400, 'h' => 300, 'type' => 'stretch' ) ) ?>" alt="image_<?= $img['id']; ?>" class="img-responsive" />
    		</div>
    	    </div>
	    <?php endforeach; ?>
	</div>

	<div id="gallery-modal-preview" class="modal fade" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 class="modal-title"><?= tr ( '_GLOBAL_preview_' ); ?></h3>
		    </div>
		    <div class="modal-body">

		    </div>
		</div>
	    </div>
	</div>

	<div class="clearfix"></div>
    </section>
</aside>