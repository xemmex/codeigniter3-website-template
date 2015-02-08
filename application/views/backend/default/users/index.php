<aside class="right-side">

    <section class="content-header">
        <h1><?= tr ( '_BACKEND_configure_users_' ) ?></h1>
        <div class="toolbar">
            <button class="btn btn-sm-block btn-success" data-toggle="modal" data-target="#user-add-modal">
                <i class="fa fa-plus"></i> <?= tr ( '_BACKEND_add_user_' ); ?>
            </button>
        </div>
        <div class="clearfix"></div>
        <?php $this->template->view ( 'users/modal/_add' ); ?>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-black box-solid">

                    <div class="box-header">
                        <h3 class="box-title"><?= tr ( '_BACKEND_configure_users_list_' ) ?></h3>
                    </div>

                    <div class="box-body">

                        <table id="users-table" class="table table-bordered table-striped table-hover table-datatables">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"><i class="glyphicon glyphicon-picture"></i></th>
                                    <th><?= tr ( '_GLOBAL_name_' ); ?></th>
                                    <th><?= tr ( '_GLOBAL_email_' ); ?></th>
                                    <th><?= tr ( '_GLOBAL_date_register_' ); ?></th>
                                    <th width="100px" class="text-center"><?= tr ( '_GLOBAL_permission_' ); ?></th>
                                    <th width="100px" class="text-center"><?= tr ( '_GLOBAL_status_' ); ?></th>
                                    <th width="180px" class="text-center"><?= tr ( '_GLOBAL_actions_' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $data['users'] as $user ): ?>
                                    <tr id="row-<?= $user['id']; ?>">
                                        <td class="text-center">
                                            <div class="media-object">
                                                <img src="<?= $user['avatar']; ?> " alt="user_avatar" class="img-circle w34">
                                            </div>
                                        </td>
                                        <td><?= $user['name']; ?> <?= $user['lastname']; ?></td>
                                        <td><?= $user['email']; ?></td>
                                        <td><?= $user['date_register']; ?></td>
                                        <td class="text-left">
                                            <span class="label label-<?= $user['permission_class']; ?> "><?= $user['permission']; ?></span>
                                        </td>
                                        <td class="text-center">

                                            <?php if ( $user['id'] == user ( 'uID' ) ) : ?>
                                                <button
                                                    class="btn <?= ( $user['status_id'] == 1 ) ? 'btn-success' : 'btn-danger'; ?>"
                                                    disabled="disabled"
                                                    title="<?= tr ( '_GLOBAL_user_in_use_' ); ?>"
                                                    >
                                                    <i class="glyphicon <?= ( $user['status_id'] == 1 ) ? 'glyphicon-ok' : 'glyphicon-remove'; ?>"></i>
                                                </button>
                                            <?php else : ?>
                                                <?php if ( $user['status_id'] == 1 ): ?>
                                                    <button
                                                        class="btn btn-success change-status"
                                                        data-url="<?= backend_url ( array ( 'helper', 'change-status' ) ); ?>"
                                                        data-table="usuarios"
                                                        data-column="uID_estados"
                                                        data-value="<?= $user['status_id']; ?>"
                                                        data-id="uID"
                                                        data-id-value="<?= $user['id']; ?>"
                                                        data-pk="uID"
                                                        data-pk-value="<?= $user['id']; ?>"
                                                        data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                        data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
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
                                                        data-table="usuarios"
                                                        data-column="uID_estados"
                                                        data-value="<?= $user['status_id']; ?>"
                                                        data-id="uID"
                                                        data-id-value="<?= $user['id']; ?>"
                                                        data-pk="uID"
                                                        data-pk-value="<?= $user['id']; ?>"
                                                        data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                        data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                                                        title="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                                                        >
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </button>
                                                <?php endif; ?>

                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= $user['url_edit']; ?>" class="btn btn-primary">
                                                <i class="glyphicon glyphicon-edit" title="<?= tr ( '_GLOBAL_edit_' ); ?>"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                               class="btn btn-warning prompt-ajax"
                                               data-url="<?= $user['url_change_password'] ?>"
                                               data-message="<?= tr ( '_GLOBAL_DIALOG_CHANGE_PASSWORD_message_' ) ?>"
                                               title="<?= tr ( '_GLOBAL_change_password_' ); ?>"
                                               >
                                                <i class="glyphicon glyphicon-lock"></i>
                                            </a>
                                            <?php if ( $user['id'] == user ( 'uID' ) ) : ?>
                                                <a  href="javascript:void(0);"
                                                    class="btn btn-danger"
                                                    disabled="disabled"
                                                    title="<?= tr ( '_GLOBAL_user_in_use_' ); ?>"
                                                    >
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </a>
                                            <?php else : ?>
                                                <a  href="javascript:void(0);"
                                                    class="btn btn-danger dialog-ajax"
                                                    data-url="<?= $user['url_delete'] ?>"
                                                    data-message="<?= tr ( '_GLOBAL_DIALOG_DELETE_USER_message_' ) ?>"
                                                    data-title="<?= tr ( '_GLOBAL_DIALOG_DELETE_USER_title_' ) ?>"
                                                    data-confirm-label="<?= tr ( '_GLOBAL_confirm_' ) ?>"
                                                    data-cancel-label="<?= tr ( '_GLOBAL_cancel_' ) ?>"
                                                    data-delete-single-row="row-<?= $user['id'] ?>"
                                                    title="<?= tr ( '_GLOBAL_delete_' ); ?>"
                                                    >
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </a>

                                            <?php endif; ?>
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