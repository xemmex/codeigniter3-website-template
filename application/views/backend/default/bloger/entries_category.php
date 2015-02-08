<aside class="right-side">
    <section class="content-header">
        <h1 class="pull-left"><?= tr ( '_PAGE_BLOG_CATEGORY_text_' ) ?> '<?= $data['category'] ?>' | <?= $data['total'] ?> <?= tr ( '_GLOBAL_records_founds_' ) ?></h1>
        <div class="pull-right toolbar">
            <a href="<?= backend_url ( array( 'bloger', 'entry-add' ) ); ?>" class="btn btn-primary">
		<i class="fa fa-plus"></i> <?= tr ( '_BACKEND_add_entry_' ); ?>
	    </a>
	    <a href="<?= backend_url ( array( 'bloger', 'categories' ) ); ?>" class="btn btn-warning">
		<i class="fa fa-tags"></i> <?= tr ( '_BACKEND_categories_' ); ?>
	    </a>
	    <a href="<?= backend_url ( array( 'bloger' ) ); ?>" class="btn btn-danger">
                <i class="fa fa-arrow-left"></i> <?= tr ( '_BACKEND_go_back_' ); ?>
            </a>
        </div>
        <div class="clearfix"></div>
	<?php $this->template->view ( 'bloger/modal/_category_add' ); ?>
    </section>
    <section class="content">
        <div class="row">
	    <div class="col-lg-9">
		<div class="row">
		    <?php $this->template->view ( 'bloger/_listing', $data ); ?>
		</div>
		<?= $data['pagination'] ?>
	    </div>
	    <div class="col-lg-3">
		<?php $this->template->view ( 'bloger/_sidebar', $data ); ?>
	    </div>
	</div>
    </section>
</aside>
