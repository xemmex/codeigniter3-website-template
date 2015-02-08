<header class="header">
    <a href="<?= backend_url (); ?>" class="logo">
        <?= tr ( '_BACKEND_title_' ); ?>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- TOOGLE -->
        <a href="javascript:void(0);" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"><?= tr ( '_GLOBAL_toogle_menu_' ); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <!-- REFRESH -->
        <a href="javascript:void(0);" class="navbar-btn sidebar-buttons reload-page" role="button" title="<?= tr ( '_GLOBAL_reload_' ); ?>">
            <span class="fa fa-refresh"></span>
        </a>
        <!-- FRONTEND -->
        <a href="<?= frontend_url (); ?>" class="navbar-btn sidebar-buttons" role="button" title="<?= tr ( '_BACKEND_go_frontend_' ); ?>" style="padding: 6px 5px 6px 2px;">
            <span class="fa fa-home" style="font-size: 25px;"></span>
        </a>


        <!-- NAVBAR -->
        <div class="navbar-right">
            <ul class="nav navbar-nav">

                <?php if ( count ( get_languages () ) > 1 ) : ?>
                    <!-- LANGUAGES -->
                    <li class="dropdown notifications-menu">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="flag <?= current_language () ?>"></i>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <ul class="menu">
                                    <li>
                                        <div class="flags" style="border-bottom: 1px solid #f4f4f4;">
                                            <i class="flag <?= current_language () ?>"></i>
                                            <?= current_language ( 'text' ) ?><br>
                                            <small><?= tr ( '_GLOBAL_current_language_' ) ?></small>
                                        </div>
                                    </li>
                                    <?php foreach ( get_languages () as $lang ) : ?>

                                        <?php if ( $lang['code'] != current_language () ) : ?>
                                            <li class="translations_<?= $lang['code']; ?>">

                                                <a href="<?= switch_lang ( $lang['code'] ) ?>" class="flags">
                                                    <i class="flag <?= $lang['code'] ?>"></i> <?= $lang['text'] ?>
                                                </a>

                                            </li>

                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- USER PROFILE -->
                <li class="dropdown user user-menu">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><?= user ( 'name' ); ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- USER IMAGE -->
                        <li class="user-header bg-light-blue">
                            <?php $user_avatar = user ( 'avatar' ); ?>
                            <?php if ( !empty ( $user_avatar ) ) : ?>
                                <img src="<?= $this->template->thumb ( 'uploads', $user_avatar, array ( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
                            <?php else : ?>
                                <img src="<?= $this->template->thumb ( 'img', '_avatars/avatar.png', array ( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
                            <?php endif; ?>
                            <?php unset ( $user_avatar ); ?>
                            <p>
                                <?= user ( 'name' ); ?>
                                <small><?= user ( 'email' ); ?></small>
                            </p>
                        </li>
                        <!-- USER LINKS -->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= backend_url ( array ( 'user', 'profile' ) ); ?>" class="btn btn-default btn-flat"><?= tr ( '_GLOBAL_my_profile_' ); ?></a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= frontend_url ( array ( 'auth', 'logout' ) ); ?>" class="btn btn-default btn-flat"><?= tr ( '_GLOBAL_logout_' ); ?></a>
                            </div>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>
</header>