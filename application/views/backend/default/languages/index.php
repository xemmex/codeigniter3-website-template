<aside class="right-side">

    <section class="content-header">
        <h1 class="pull-left"><?= tr ( '_BACKEND_configure_languages_' ) ?></h1>
        <div class="pull-right toolbar">
            <button class="btn btn-sm-block btn-success" data-toggle="modal" data-target="#language-add-modal">
                <i class="fa fa-plus"></i> <?= tr ( '_BACKEND_add_language_' ); ?>
            </button>
            <button class="btn btn-sm-block btn-warning" data-toggle="modal" data-target="#translation-add-modal">
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
                        <h3 class="box-title"><?= tr ( '_BACKEND_configure_languages_list_' ) ?></h3>
                    </div>

                    <div class="box-body no-padding">


                        <table
                            class="table table-striped table-responsive table-bordered table-sortable"
                            data-url="<?= backend_url ( array( 'helper', 're-order' ) ); ?>"
                            >
                            <thead>
                                <tr>
				<th width="36px" class="text-center hidden-xs">#</th>
				<th width="36px" class="text-center"><i class="fa fa-globe"></i></th>
				<th width="100px"><?= tr ( '_GLOBAL_language_code_' ); ?></th>
				<th class="hidden-xs"><?= tr ( '_GLOBAL_name_' ); ?></th>
				<th width="100px" class="text-center"><?= tr ( '_GLOBAL_show_keys_' ); ?></th>
				<th width="100px" class="text-center"><?= tr ( '_GLOBAL_default_' ); ?></th>
				<th width="100px" class="text-center"><?= tr ( '_GLOBAL_status_' ); ?></th>
				<th width="130px" class="text-center"><?= tr ( '_GLOBAL_actions_' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
				<?php foreach ( $data['languages'] as $languages ): ?>
    				<tr
    				    id="row-<?= $languages['id']; ?>"
    				    data-table="idiomas"
    				    data-column="order"
    				    data-id="uID"
    				    data-id_value="<?= $languages['id']; ?>"
    				    data-pk-="uID"
    				    data-pk-value-="<?= $languages['id']; ?>"
    				    >
    				<td class="hidden-xs"><i class="fa fa-arrows-alt btn-sortable" title="<?= tr ( '_GLOBAL_select_to_reoder_' ); ?>"></i></td>
    				<td class="text-center">
    				<span class="nm flag <?= $languages['code']; ?>"></span>
    				</td>
    				<td><?= $languages['code']; ?></td>
    				<td class="hidden-xs">
    				    <a href="javascript:void(0);"
    				       class="change-value"
    				       data-name="uID"
    				       data-editable-table="idiomas"
    				       data-editable-column="text"
    				       data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
    				       data-editable-pk="<?= $languages['id']; ?>"
    				       data-editable-url="<?= backend_url ( array( 'helper', 'change-value' ) ); ?>"
    				       data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
    				       data-editable-rules="required"
    				       data-editable-mode="popup"
    				       ><?= $languages['text']; ?></a>
    				</td>

    				<td class="text-center">
					<?php if ( $languages['show_keys'] == 1 ): ?>
					<button
					    class="btn btn-success change-status"
					    data-url="<?= backend_url ( array( 'helper', 'change-status' ) ); ?>"
					    data-table="idiomas"
					    data-column="show_keys"
					    data-value="<?= $languages['show_keys']; ?>"
					    data-id="uID"
					    data-id-value="<?= $languages['id']; ?>"
					    data-pk="uID"
					    data-pk-value="<?= $languages['id']; ?>"
					    data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
					    data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
					    title="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
					    >
					    <i class="glyphicon glyphicon-ok"></i>
					</button>
				    <?php else : ?>
					<button
					    class="btn btn-danger change-status"
					    data-url="<?= backend_url ( array( 'helper', 'change-status' ) ); ?>"
					    data-table="idiomas"
					    data-column="show_keys"
					    data-value="<?= $languages['show_keys']; ?>"
					    data-id="uID"
					    data-id-value="<?= $languages['id']; ?>"
					    data-pk="uID"
					    data-pk-value="<?= $languages['id']; ?>"
					    data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
					    data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
					    title="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
					    >
					    <i class="glyphicon glyphicon-remove"></i>
					</button>
				    <?php endif; ?>
    				</td>
    				<td class="text-center">
					<?php if ( $languages['default'] == 1 ): ?>
					<button
					    class="btn btn-info change-default"
					    disabled="disabled"
					    data-url="<?= backend_url ( array( 'helper', 'change-default' ) ); ?>"
					    data-table="idiomas"
					    data-column="defecto"
					    data-id="uID"
					    data-id-value="<?= $languages['id']; ?>"
					    title="<?= tr ( '_GLOBAL_default_yes_tooltip_' ); ?>"
					    data-title-default-yes="<?= tr ( '_GLOBAL_default_yes_tooltip_' ); ?>"
					    data-title-default-no="<?= tr ( '_GLOBAL_default_no_tooltip_' ); ?>"
					    >
					    <i class="glyphicon glyphicon-ok"></i>
					</button>
				    <?php else: ?>
					<button
					    class="btn btn-default change-default"
					    data-url="<?= backend_url ( array( 'helper', 'change-default' ) ); ?>"
					    data-table="idiomas"
					    data-column="defecto"
					    data-id="uID"
					    data-id-value="<?= $languages['id']; ?>"
					    title="<?= tr ( '_GLOBAL_default_no_tooltip_' ); ?>"
					    data-title-default-yes="<?= tr ( '_GLOBAL_default_yes_tooltip_' ); ?>"
					    data-title-default-no="<?= tr ( '_GLOBAL_default_no_tooltip_' ); ?>"
					    >
					    <i class="glyphicon glyphicon-minus"></i>
					</button>
				    <?php endif; ?>
    				</td>

    				<td class="text-center">
					<?php if ( $languages['code'] == current_language ( 'code' ) ) : ?>
					<button
					    class="btn <?= ($languages['code'] == current_language ( 'code' ) ) ? 'btn-success' : 'btn-danger'; ?>"
					    disabled="disabled"
					    title="<?= tr ( '_GLOBAL_language_in_use_' ); ?>"
					    >
					    <i class="glyphicon <?= ( $languages['code'] == current_language ( 'code' ) ) ? 'glyphicon-ok' : 'glyphicon-remove'; ?>"></i>
					</button>
				    <?php else : ?>
					<?php if ( $languages['status_id'] == 1 ): ?>
	    				<button
	    				    class="btn btn-success change-status"
	    				    data-url="<?= backend_url ( array( 'helper', 'change-status' ) ); ?>"
	    				    data-table="idiomas"
	    				    data-column="uID_estados"
	    				    data-value="<?= $languages['status_id']; ?>"
	    				    data-id="uID"
	    				    data-id-value="<?= $languages['id']; ?>"
	    				    data-pk="uID"
	    				    data-pk-value="<?= $languages['id']; ?>"
	    				    data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
	    				    data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
	    				    title="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
	    				    >
	    				    <i class="glyphicon glyphicon-ok"></i>
	    				</button>
					<?php else : ?>
	    				<button
	    				    class="btn btn-danger change-status"
	    				    data-url="<?= backend_url ( array( 'helper', 'change-status' ) ); ?>"
	    				    data-table="idiomas"
	    				    data-column="uID_estados"
	    				    data-value="<?= $languages['status_id']; ?>"
	    				    data-id="uID"
	    				    data-id-value="<?= $languages['id']; ?>"
	    				    data-pk="uID"
	    				    data-pk-value="<?= $languages['id']; ?>"
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
    				    <a href="<?= $languages['url_translations']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-globe" title="<?= tr ( '_GLOBAL_view_translations_' ); ?>"></i></a>
					<?php if ( $languages['code'] == current_language ( 'code' ) ) : ?>
					    <a  href="javascript:void(0);"
						class="btn btn-danger"
						disabled="disabled"
						title="<?= tr ( '_GLOBAL_language_in_use_' ); ?>"
						>
						<i class="glyphicon glyphicon-trash"></i>
					    </a>
					<?php else : ?>
					    <a  href="javascript:void(0);"
						class="btn btn-danger dialog-ajax"
						data-url="<?= $languages['url_delete'] ?>"
						data-message="<?= tr ( '_GLOBAL_DIALOG_DELETE_LANGUAGE_message_' ) ?>"
						data-title="<?= tr ( '_GLOBAL_DIALOG_DELETE_LANGUAGE_title_' ) ?>"
						data-confirm-label="<?= tr ( '_GLOBAL_confirm_' ) ?>"
						data-cancel-label="<?= tr ( '_GLOBAL_cancel_' ) ?>"
						data-delete-single-row="row-<?= $languages['id'] ?>"
						data-delete-element=".translations_<?= $languages['code'] ?>"
						data-delete-editor="translation[<?= $languages['id'] ?>]"
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