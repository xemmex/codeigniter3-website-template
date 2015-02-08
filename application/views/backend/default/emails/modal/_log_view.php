<div class="box box-solid box-warning">
    <div class="box-header">
        <h3 class="box-title"><?= tr ( '_GLOBAL_details_' ); ?></h3>
    </div>
    <div class="box-body">
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <td><?= tr ( '_GLOBAL_email_type_' ); ?></td>
                    <td><span class="label label-info"><?= $log['email_type']; ?></span></td>
                </tr>
                <tr>
                    <td><?= tr ( '_GLOBAL_date_log_' ); ?></td>
                    <td><?= $log['date']; ?></td>
                </tr>
                <tr>
                    <td><?= tr ( '_GLOBAL_status_' ); ?></td>
                    <td><span class="label <?= ($log['status'] == 'OK' ) ? 'label-success' : 'label-danger'; ?>"><?= $log['status']; ?></span></td>
                </tr>
                <tr>
                    <td><?= tr ( '_GLOBAL_recipients_' ); ?></td>
                    <td>
                        <?php foreach ( unserialize ( $log['emails'] ) as $email ) : ?>
                            <span class="label label-primary"><?= $email['email']; ?></span><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td><?= tr ( '_GLOBAL_subject_' ); ?></td>
                    <td><?= $log['subject']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="box box-solid box-success collapsed-box">
    <div class="box-header">
        <h3 class="box-title"><?= tr ( '_GLOBAL_preview_message_' ); ?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body" style="display:none;">
        <table class="table table-striped table-bordered">
            <?= $log['message']; ?>
        </table>
    </div>
</div>

<?php if ( !empty ( $log['debug'] ) ): ?>

    <div class="box box-solid box-danger collapsed-box">
        <div class="box-header">
            <h3 class="box-title"><?= tr ( '_GLOBAL_debug_' ); ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-danger btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="box-body" style="display:none;">
            <table class="table table-striped table-bordered">
                <?= $log['debug']; ?>
            </table>
        </div>
    </div>
<?php endif; ?>