<aside class="right-side">

    <section class="content-header">
        <h1><?= tr ( '_BACKEND_phpinfo_' ) ?></h1>
        <div class="pull-right toolbar">
            <a href="<?= backend_url ( array( 'system-settings' ) ); ?>" class="btn btn-sm-block btn-danger">
                <i class="fa fa-arrow-left"></i> <?= tr ( '_BACKEND_go_back_' ); ?>
            </a>
        </div>
        <div class="clearfix"></div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
		<?= phpinfo (); ?>
            </div>
        </div>
    </section>
</aside>