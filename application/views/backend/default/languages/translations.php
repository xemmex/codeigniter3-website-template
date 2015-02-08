<aside class="right-side">
    <section class="content-header">
        <h1 class="pull-left"><?= tr ( '_BACKEND_configure_translations_' ) ?></h1>
        <div class="pull-right toolbar">
            <a href="<?= backend_url ( array ( 'languages' ) ); ?>" class="btn btn-sm-block btn-danger">
                <i class="fa fa-arrow-left"></i> <?= tr ( '_BACKEND_go_back_' ); ?>
            </a>
            <button class="btn btn-sm-block btn-success" data-toggle="modal" data-target="#translation-add-modal">
                <i class="fa fa-plus"></i> <?= tr ( '_BACKEND_add_translation_' ); ?>
            </button>
        </div>
        <div class="clearfix"></div>
        <?php $this->template->view ( 'languages/modal/_language_add' ); ?>
        <?php $this->template->view ( 'languages/modal/_translation_add' ); ?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box box-black box-solid">

                    <div class="box-header">
                        <h3 class="box-title">
                            <?= all_languages ( $data['language'], 'text' ); ?>
                        </h3>
                    </div>

                    <div class="box-body">

                        <table id="translations-table" data-url="<?= backend_url ( array ( 'languages', 'translations', $data['language'] ) ); ?>" class="table table-bordered table-striped table-hover table-datatables-server">
                            <thead>
                                <tr>
                                    <th><?= tr ( '_GLOBAL_translation_key_' ); ?></th>
                                    <th class="hidden-xs hidden-sm"><?= tr ( '_GLOBAL_translation_text_' ); ?></th>
                                    <th width="130px" class="text-center"><?= tr ( '_GLOBAL_actions_' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>