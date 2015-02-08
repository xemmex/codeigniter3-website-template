<aside class="right-side">

    <section class="content-header">
        <h1><?= tr ( '_BACKEND_templates_emails_' ) ?></h1>
        <div class="toolbar">
            <a href="<?= backend_url ( array( 'emails' ) ); ?>" class="btn btn-sm-block btn-danger">
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
                        <h3 class="box-title"><?= tr ( '_BACKEND_configure_template_list_' ) ?></h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th><?= tr ( '_GLOBAL_name_' ); ?></th>
                                    <th class="hidden-xs"><?= tr ( '_GLOBAL_variables_' ); ?></th>
                                    <th width="110px" class="text-center"><?= tr ( '_GLOBAL_actions_' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
				<?php foreach ( $data['emails_types'] as $type ): ?>
    				<tr id="row-<?= $type['id']; ?>">
    				    <td><?= $type['text'] ?></td>
    				    <td class="hidden-xs"><?= $type['variables'] ?></td>
    				    <td class="text-center">
    					<button
    					    class="btn btn-warning info-ajax"
    					    data-url="<?= $type['url_view']; ?>"
    					    title="<?= tr ( '_GLOBAL_preview_' ); ?>"
    					    data-title="<?= tr ( '_GLOBAL_preview_' ); ?>"
    					    >
    					    <i class="glyphicon glyphicon-eye-open"></i>
    					</button>
    					<button
    					    class="btn btn-primary modal-ajax"
    					    data-url="<?= $type['url_edit']; ?>"
    					    data-modal-id="#template-edit-<?= $type['id']; ?>"
    					    title="<?= tr ( '_GLOBAL_edit_' ); ?>"
    					    >
    					    <i class="glyphicon glyphicon-edit"></i>
    					</button>
    				    </td>
    				</tr>
				<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>