<aside class="right-side">

    <section class="content-header">
        <h1 class="pull-left"><?= tr ( '_BACKEND_configure_emails_' ) ?></h1>
        <div class="pull-right toolbar">
            <button class="btn btn-sm-block btn-success" data-toggle="modal" data-target="#emails-add-modal">
                <i class="fa fa-plus"></i> <?= tr ( '_BACKEND_add_email_' ); ?>
            </button>
            <a class="btn btn-sm-block btn-warning" href="<?= backend_url ( array ( 'emails', 'templates' ) ); ?>" >
                <i class="fa fa-paint-brush"></i> <?= tr ( '_BACKEND_emails_templates_' ); ?>
            </a>
            <a class="btn btn-sm-block btn-warning" href="<?= backend_url ( array ( 'emails', 'logs' ) ); ?>" >
                <i class="fa fa-envelope-o"></i> <?= tr ( '_BACKEND_emails_log_' ); ?>
            </a>
        </div>
        <div class="clearfix"></div>

        <div class="modal-hidden-content">
            <div class="modal fade" id="emails-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content box box-solid box-primary">

                        <div class="modal-header box-header">
                            <button data-dismiss="modal" class="close" type="button">×</button>
                            <h3 class= modal-title"><?= tr ( '_BACKEND_add_email_' ) ?></h3>
                        </div>

                        <?= form_open ( 'backend/emails/emails-add', array ( 'class' => 'form-horizontal form-ajax', 'id' => '_add_emails_form', 'role' => 'form' ) ); ?>

                        <div class="modal-body">

                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_name_' ); ?></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                        <?=
                                        form_input ( array (
                                            'type' => 'text',
                                            'name' => 'name',
                                            'value' => set_value ( 'name' ),
                                            'id' => 'name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'autofocus' => 'autofocus'
                                        ) );
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_email_' ); ?></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                        <?=
                                        form_input ( array (
                                            'type' => 'email',
                                            'name' => 'email',
                                            'value' => set_value ( 'email' ),
                                            'id' => 'email',
                                            'class' => 'form-control',
                                            'required' => 'required'
                                        ) );
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="cco" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_cco_field_' ); ?></label>

                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-question-sign"></span></span>
                                        <select name="cco" id="status" class="form-control">
                                            <option value="0" <?= set_select ( 'cco', '0' ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( 'cco', '1' ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="status" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_status_' ); ?></label>

                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-question-sign"></span></span>
                                        <select name="status" id="status" class="form-control">
                                            <option value="0" <?= set_select ( 'status', '0' ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( 'status', '1' ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?= tr ( '_GLOBAL_emails_types_' ); ?></label>
                                <div class="col-sm-9">
                                    <?php foreach ( $data['emails_types'] as $emails_types ) : ?>
                                        <span class="checkbox custom-checkbox custom-checkbox-inverse">
                                            <input type="checkbox" id="emails_types_<?= $emails_types['id']; ?>" name="emails_types[]" value="<?= $emails_types['id']; ?>">
                                            <label for="emails_types_<?= $emails_types['id']; ?>">&nbsp;&nbsp;<?= $emails_types['text']; ?></label>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success ladda-button" data-style="expand-left">
                                <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_add_' ); ?></span>
                            </button>
                        </div>
                        <?= form_close (); ?>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-black box-solid">

                    <div class="box-header">
                        <h3 class="box-title"><?= tr ( '_BACKEND_configure_emails_list_' ) ?></h3>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="hidden-xs"><?= tr ( '_GLOBAL_name_' ); ?></th>
                                    <th><?= tr ( '_GLOBAL_email_' ); ?></th>
                                    <th><?= tr ( '_GLOBAL_emails_types_' ); ?></th>
                                    <th width="100px" class="text-center"><?= tr ( '_GLOBAL_cco_field_' ); ?></th>
                                    <th width="100px" class="text-center"><?= tr ( '_GLOBAL_status_' ); ?></th>
                                    <th width="45px" class="text-center"><?= tr ( '_GLOBAL_actions_' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $data['emails'] as $email ): ?>
                                    <tr id="row-<?= $email['id']; ?>">
                                        <td class="hidden-xs">
                                            <a href="javascript:void(0);"
                                               class="change-value"
                                               data-name="uID"
                                               data-editable-table="emails"
                                               data-editable-column="nombre"
                                               data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
                                               data-editable-pk="<?= $email['id']; ?>"
                                               data-editable-url="<?= backend_url ( array ( 'helper', 'change-value' ) ); ?>"
                                               data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
                                               data-editable-rules="required"
                                               data-editable-mode="popup"
                                               ><?= $email['name']; ?></a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);"
                                               class="change-value"
                                               data-name="uID"
                                               data-editable-table="emails"
                                               data-editable-column="email"
                                               data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
                                               data-editable-pk="<?= $email['id']; ?>"
                                               data-editable-url="<?= backend_url ( array ( 'helper', 'change-value' ) ); ?>"
                                               data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
                                               data-editable-rules="required|valid_email"
                                               data-editable-mode="popup"
                                               ><?= $email['email']; ?></a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);"
                                               class="change-list"
                                               data-name="uID"
                                               data-editable-table="emails"
                                               data-editable-column="uID_emails_tipos"
                                               data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
                                               data-editable-pk="<?= $email['id']; ?>"
                                               data-editable-url="<?= backend_url ( array ( 'helper', 'change-list' ) ); ?>"
                                               data-editable-source="<?= backend_url ( array ( 'emails', 'emails-get-types' ) ); ?>"
                                               data-value="<?= $email['emails_types_id']; ?>"
                                               data-editable-title="<?= tr ( '_GLOBAL_select_options_' ); ?>"
                                               data-editable-rules="required"
                                               data-editable-mode="popup"
                                               data-editable-type="checklist"
                                               data-editable-class="info"
                                               >
                                                   <?php foreach ( $email['emails_types'] as $email_type ): ?>
                                                    <span class="label label-info"><?= $email_type['text']; ?></span><br>
                                                <?php endforeach; ?>
                                            </a>

                                        </td>
                                        <td class="text-center">
                                            <?php if ( $email['cco'] == 1 ): ?>
                                                <button
                                                    class="btn btn-success change-status"
                                                    data-url="<?= backend_url ( array ( 'helper', 'change-status' ) ); ?>"
                                                    data-table="emails"
                                                    data-column="oculto"
                                                    data-value="<?= $email['status_id']; ?>"
                                                    data-id="uID"
                                                    data-id-value="<?= $email['id']; ?>"
                                                    data-pk="uID"
                                                    data-pk-value="<?= $email['id']; ?>"
                                                    data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                    data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                                                    title="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                                                    >
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </button>
                                            <?php else : ?>
                                                <button
                                                    class="btn btn-danger change-status"
                                                    data-url="<?= backend_url ( array ( 'helper', 'change-status' ) ); ?>"
                                                    data-table="emails"
                                                    data-column="oculto"
                                                    data-value="<?= $email['status_id']; ?>"
                                                    data-id="uID"
                                                    data-id-value="<?= $email['id']; ?>"
                                                    data-pk="uID"
                                                    data-pk-value="<?= $email['id']; ?>"
                                                    data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                    data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                                                    title="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                    >
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ( $email['status_id'] == 1 ): ?>
                                                <button
                                                    class="btn btn-success change-status"
                                                    data-url="<?= backend_url ( array ( 'helper', 'change-status' ) ); ?>"
                                                    data-table="emails"
                                                    data-column="uID_estados"
                                                    data-value="<?= $email['status_id']; ?>"
                                                    data-id="uID"
                                                    data-id-value="<?= $email['id']; ?>"
                                                    data-pk="uID"
                                                    data-pk-value="<?= $email['id']; ?>"
                                                    data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                    data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                                                    title="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                                                    >
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </button>
                                            <?php else : ?>
                                                <button
                                                    class="btn btn-danger change-status"
                                                    data-url="<?= backend_url ( array ( 'helper', 'change-status' ) ); ?>"
                                                    data-table="emails"
                                                    data-column="uID_estados"
                                                    data-value="<?= $email['status_id']; ?>"
                                                    data-id="uID"
                                                    data-id-value="<?= $email['id']; ?>"
                                                    data-pk="uID"
                                                    data-pk-value="<?= $email['id']; ?>"
                                                    data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                    data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                                                    title="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                    >
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <a  href="javascript:void(0);"
                                                class="btn btn-danger dialog-ajax"
                                                data-url="<?= $email['url_delete'] ?>"
                                                data-message="<?= tr ( '_GLOBAL_DIALOG_DELETE_EMAILS_message_' ) ?>"
                                                data-title="<?= tr ( '_GLOBAL_DIALOG_DELETE_EMAILS_title_' ) ?>"
                                                data-confirm-label="<?= tr ( '_GLOBAL_confirm_' ) ?>"
                                                data-cancel-label="<?= tr ( '_GLOBAL_cancel_' ) ?>"
                                                data-delete-single-row="row-<?= $email['id'] ?>"
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
        </div>
    </section>

</aside>