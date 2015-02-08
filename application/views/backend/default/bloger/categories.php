<aside class="right-side">

    <section class="content-header">
        <h1 class="pull-left"><?= tr ( '_BACKEND_configure_categories_' ) ?></h1>
        <div class="pull-right toolbar">
            <button class="btn btn-primary" data-toggle="modal" data-target="#category-add-modal">
                <i class="fa fa-plus"></i> <?= tr ( '_BACKEND_add_category_' ); ?>
            </button>
            <a href="<?= backend_url ( array( 'bloger' ) ); ?>" class="btn btn-danger">
                <i class="fa fa-arrow-left"></i> <?= tr ( '_BACKEND_go_back_' ); ?>
            </a>
        </div>
        <div class="clearfix"></div>
	<?php $this->template->view ( 'bloger/modal/_category_add' ); ?>
    </section>

    <section class="content">
        <div class="row">

	    <div class="col-md-12">
		<div class="box box-black box-solid">

		    <div class="box-header">
                        <h3 class="box-title"><?= tr ( '_BACKEND_configure_categories_list_' ) ?></h3>
                    </div>

                    <div class="box-body">

                        <table id="blog-categories-table" class="table table-bordered table-striped table-hover table-datatables">
			    <thead>
				<tr>
				    <th><?= tr ( '_GLOBAL_name_' ); ?></th>
				    <th width="130px" class="text-center"><?= tr ( '_GLOBAL_actions_' ); ?></th>
				</tr>
			    </thead>
			    <tbody>
				<?php foreach ( $data['categories'] as $category ): ?>
    				<tr id="row-<?= $category['id']; ?>">
    				    <td>
    					<a href="javascript:void(0);"
    					   class="change-value"
    					   data-name="uID"
    					   data-editable-table="blog_categorias"
    					   data-editable-column="texto"
    					   data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
    					   data-editable-pk="<?= $category['id']; ?>"
    					   data-editable-url="<?= backend_url ( array( 'helper', 'change-value' ) ); ?>"
    					   data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
    					   data-editable-rules="required"
    					   data-editable-mode="popup"
    					   ><?= $category['text']; ?></a>
    				    </td>
    				    <td class="text-center">
    					<a href="<?= $category['url_edit']; ?>" class="btn btn-primary">
    					    <i class="glyphicon glyphicon-edit"></i>
    					</a>
    					<a  href="javascript:void(0);"
    					    class="btn btn-danger dialog-ajax"
    					    data-url="<?= $category['url_delete']; ?>"
    					    data-message="<?= tr ( '_GLOBAL_DIALOG_DELETE_CATEGORY_message_' ) ?>"
    					    data-title="<?= tr ( '_GLOBAL_DIALOG_DELETE_CATEGORY_title_' ) ?>"
    					    data-confirm-label="<?= tr ( '_GLOBAL_confirm_' ) ?>"
    					    data-cancel-label="<?= tr ( '_GLOBAL_cancel_' ) ?>"
    					    data-delete-datatables="true"
    					    title="<?= tr ( '_GLOBAL_delete_' ); ?>"
    					    >
    					    <i class="glyphicon glyphicon-trash"></i>
    					</a>
    				    </td>
    				</tr>
				<?php endforeach; ?>
			    </tbody>
			</table>

		    </div>
		</div>
	    </div>
    </section>
</aside>