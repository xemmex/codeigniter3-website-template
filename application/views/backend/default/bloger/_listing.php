<?php foreach ( $data['entries'] as $entry ): ?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 post entry-<?= $entry['id']; ?>">
        <article class="panel overflow-hidden">
            <?php if ( isset ( $entry['imagen'] ) ) : ?>
                <header class="thumbnail">
                    <div class="media">
                        <div class="indicator"><span class="spinner"></span></div>
                        <div class="overlay">
                            <div class="toolbar">
                                <a href="<?= $entry['url_edit'] ?>" class="btn btn-default" title="<?= $entry['title'] ?>"><i class="ico-link4"></i></a>
                            </div>
                        </div>
                        <img
                            data-toggle="unveil"
                            src="<?= $this->template->path ( 'img', '_blog/placeholder.jpg' ); ?>"
                            data-src="<?= $this->template->thumb ( 'uploads', $entry['imagen'], array ( 'w' => 850, 'h' => 300, 'type' => 'crop' ) ); ?>"
                            alt="<?= $entry['title'] ?>"
                            width="100%"
                            >
                    </div>
                </header>
            <?php endif; ?>
            <section class="panel-body">
                <h4 class="thin mt0 ellipsis">
                    <a href="<?= $entry['url_edit'] ?>" class="text-default" title="<?= $entry['title'] ?>"><?= $entry['title'] ?></a>
                </h4>
                <p class="meta mb15">
                    <span class="text-muted mr5 ml5"><?= $entry['date'] ?></span>
                    <span class="text-muted mr5 ml5">&#8226;</span>
                    <a href="javascript:void(0);"
                       class="change-list"
                       data-name="uID"
                       data-editable-table="blog"
                       data-editable-column="uID_blog_categorias"
                       data-editable-title="<?= tr ( '_GLOBAL_change_value_' ); ?>"
                       data-editable-pk="<?= $entry['id']; ?>"
                       data-editable-url="<?= backend_url ( array ( 'helper', 'change-value' ) ); ?>"
                       data-editable-source="<?= backend_url ( array ( 'bloger', 'categories-get' ) ); ?>"
                       data-value="<?= $entry['category_id']; ?>"
                       data-editable-title="<?= tr ( '_GLOBAL_select_options_' ); ?>"
                       data-editable-rules="required"
                       data-editable-mode="popup"
                       data-editable-type="select"
                       data-editable-class="primary"
                       >
                        <span class="label label-primary"><?= $entry['category']; ?></span>
                    </a>
                </p>
                <?php if ( $entry['status_id'] == 1 ): ?>
                    <button
                        class="btn btn-success change-status"
                        data-url="<?= backend_url ( array ( 'helper', 'change-status' ) ); ?>"
                        data-table="blog"
                        data-column="uID_estados"
                        data-value="<?= $entry['status_id']; ?>"
                        data-id="uID"
                        data-id-value="<?= $entry['id']; ?>"
                        data-pk="uID"
                        data-pk-value="<?= $entry['id']; ?>"
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
                        data-table="blog"
                        data-column="uID_estados"
                        data-value="<?= $entry['status_id']; ?>"
                        data-id="uID"
                        data-id-value="<?= $entry['id']; ?>"
                        data-pk="uID"
                        data-pk-value="<?= $entry['id']; ?>"
                        data-title-activate="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                        data-title-desactivate="<?= tr ( '_GLOBAL_desactivate_tooltip_' ); ?>"
                        title="<?= tr ( '_GLOBAL_activate_tooltip_' ); ?>"
                        >
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                <?php endif; ?>

                <a href="<?= $entry['url_edit'] ?>" class="btn btn-info"><i class="icon ico-pencil"></i></a>

                <a  href="javascript:void(0);"
                    class="btn btn-danger dialog-ajax"
                    data-url="<?= $entry['url_delete'] ?>"
                    data-message="<?= tr ( '_GLOBAL_DIALOG_DELETE_BLOG_message_' ) ?>"
                    data-title="<?= tr ( '_GLOBAL_DIALOG_DELETE_BLOG_title_' ) ?>"
                    data-confirm-label="<?= tr ( '_GLOBAL_confirm_' ) ?>"
                    data-cancel-label="<?= tr ( '_GLOBAL_cancel_' ) ?>"
                    data-delete-element=".entry-<?= $entry['id'] ?>"
                    title="<?= tr ( '_GLOBAL_delete_' ); ?>"
                    >
                    <i class="icon ico-remove3"></i>
                </a>
            </section>
        </article>
    </div>
<?php endforeach; ?>