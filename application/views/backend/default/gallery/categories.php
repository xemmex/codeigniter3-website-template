<aside class="right-side">

    <section class="content-header">
        <h1 class="pull-left"><?= tr ( '_BACKEND_configure_categories_' ) ?></h1>
        <div class="pull-right toolbar">
            <a href="<?= backend_url ( array( 'gallery' ) ); ?>" class="btn btn-danger">
                <i class="fa fa-arrow-left"></i> <?= tr ( '_BACKEND_go_back_' ); ?>
            </a>
        </div>
        <div class="clearfix"></div>
    </section>

    <section class="content">
        <div class="row">

	    <div class="col-md-12">
		<div class="box box-black box-solid">

		    <div class="box-header">
                        <h3 class="box-title"><?= tr ( '_BACKEND_configure_categories_list_' ) ?></h3>
                    </div>

                    <div class="box-body no-padding">

                        <table id="blog-categories-table" class="table table-bordered table-striped table-hover">
			    <thead>
				<tr>
				<th><?= tr ( '_GLOBAL_name_' ); ?></th>
				</tr>
			    </thead>
			    <tbody>
				<?php foreach ( $data['categories'] as $category ): ?>
    				<tr id="row-<?= $category['id']; ?>">
    				<td>
    				    <a href="javascript:void(0);"
    				       class="change-value"
    				       data-name="uID"
    				       data-editable-table="galeria"
    				       data-editable-column="name"
    				       data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
    				       data-editable-pk="<?= $category['id']; ?>"
    				       data-editable-url="<?= backend_url ( array( 'helper', 'change-value' ) ); ?>"
    				       data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
    				       data-editable-rules="required"
    				       data-editable-mode="popup"
    				       ><?= $category['name']; ?></a>
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