<aside class="right-side">

    <section class="content-header">
        <h1><?= tr ( '_BACKEND_logs_emails_' ) ?></h1>
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
                        <h3 class="box-title"><?= tr ( '_BACKEND_logs_emails_' ) ?></h3>
                    </div>

                    <div class="box-body">

                        <table id="users-table" class="table table-bordered table-datatables">
                            <thead>
                                <tr>
                                    <th><?= tr ( '_GLOBAL_date_log_' ); ?></th>
                                    <th class="hidden-xs"><?= tr ( '_GLOBAL_status_' ); ?></th>
                                    <th><?= tr ( '_GLOBAL_email_type_' ); ?></th>
                                    <th><?= tr ( '_GLOBAL_recipients_' ); ?></th>
                                    <th class="hidden-xs"><?= tr ( '_GLOBAL_subject_' ); ?></th>
                                    <th width="45px" class="text-center"><?= tr ( '_GLOBAL_actions_' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
				<?php foreach ( $data['logs'] as $log ): ?>
    				<tr class="<?= ($log['status'] == 'OK') ? 'success' : 'danger'; ?>">
    				    <td><?= $log['date']; ?></td>
    				    <td class="hidden-xs">
    					<span class="label <?= ($log['status'] == 'OK' ) ? 'label-success' : 'label-danger'; ?>"><?= $log['status']; ?></span>
    				    </td>
    				    <td><span class="label label-info"><?= $log['email_type']; ?></span></td>
    				    <td>
					    <?php foreach ( unserialize ( $log['emails'] ) as $email ) : ?>
						<span class="label label-primary"><?= $email['email']; ?></span>
					    <?php endforeach; ?>
    				    </td>
    				    <td class="hidden-xs"><?= $log['subject']; ?></td>
    				    <td class="text-center">
    					<button
    					    class="btn btn-warning info-ajax"
    					    data-url="<?= $log['url_view']; ?>"
    					    title="<?= tr ( '_GLOBAL_view_' ); ?>"
    					    data-title="<?= tr ( '_GLOBAL_view_log_' ); ?>"
    					    >
    					    <i class="glyphicon glyphicon-eye-open"></i>
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