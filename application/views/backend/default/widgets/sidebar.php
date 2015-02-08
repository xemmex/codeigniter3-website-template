

<aside class="left-side sidebar-offcanvas">

    <!-- SIDEBAR -->
    <section class="sidebar">

        <!-- USER INFO -->
        <div class="user-panel">
            <div class="pull-left image">
		<?php $user_avatar = user ( 'avatar' ); ?>
		<?php if ( !empty ( $user_avatar ) ) : ?>
    		<img src="<?= $this->template->thumb ( 'uploads', $user_avatar, array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
		<?php else : ?>
    		<img src="<?= $this->template->thumb ( 'img', '_avatars/avatar.png', array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
		<?php endif; ?>
		<?php unset ( $user_avatar ); ?>
            </div>
            <div class="pull-left info">
                <p><?= user ( 'name' ); ?></p>
                <a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> <?= user ( 'email' ); ?></a>
            </div>
        </div>

        <!-- SEARCH -->
        <h5 class="heading">Inicio</h5>

        <!-- MENU -->
        <ul class="sidebar-menu">

            <li<?= is_active ( array( 'user', 'profile' ), ' class="active"' ) ?>>
                <a href="<?= backend_url ( array( 'user', 'profile' ) ); ?>">
                    <i class="fa fa-user"></i> <span><?= tr ( '_GLOBAL_my_profile_' ); ?></span>
                </a>
            </li>
        </ul>

        <h5 class="heading"><?= tr ( '_GLOBAL_menu_' ); ?></h5>

        <ul class="sidebar-menu">

	    <?php if ( check_pemission_controller ( 'System_settings' ) ) : ?>
    	    <li class="treeview<?= is_active_dropdown ( array( 'system-settings', 'languages', 'users', 'emails' ), ' active' ) ?>">
    		<a href="javascript:void(0);">
    		    <i class="fa fa-cogs"></i>
    		    <span><?= tr ( '_BACKEND_settings_' ); ?></span>
    		    <i class="fa fa-angle-left pull-right"></i>
    		</a>
    		<ul class="treeview-menu">
    		    <li<?= is_active ( array( 'system-settings' ) ) ?> >
    			<a href="<?= backend_url ( array( 'system-settings' ) ); ?>">
    			    <i class="fa fa-angle-right"></i>
				<?= tr ( '_BACKEND_configure_system_' ); ?>
    			</a>
    		    </li>
			<?php if ( check_pemission_controller ( 'Languages' ) ) : ?>
			    <li<?= is_active ( array( 'languages' ) ) ?>>
				<a href="<?= backend_url ( array( 'languages' ) ); ?>">
				    <i class="fa fa-angle-right"></i>
				    <?= tr ( '_BACKEND_configure_languages_' ); ?>
				</a>
			    </li>
			<?php endif; ?>
			<?php if ( check_pemission_controller ( 'Users' ) ) : ?>
			    <li<?= is_active ( array( 'users' ), ' class="active"' ) ?>>
				<a href="<?= backend_url ( array( 'users' ) ); ?>">
				    <i class="fa fa-angle-right"></i>
				    <?= tr ( '_BACKEND_configure_users_' ); ?>
				</a>
			    </li>
			<?php endif; ?>
			<?php if ( check_pemission_controller ( 'Emails' ) ) : ?>
			    <li<?= is_active ( array( 'emails' ) ) ?>>
				<a href="<?= backend_url ( array( 'emails' ) ); ?>">
				    <i class="fa fa-angle-right"></i>
				    <?= tr ( '_BACKEND_configure_emails_' ); ?>
				</a>
			    </li>
			<?php endif; ?>
    		</ul>
    	    </li>
	    <?php endif; ?>
	    <?php if ( check_pemission_controller ( 'Bloger' ) ) : ?>
    	    <li<?= is_active ( array( 'bloger' ) ) ?>>
    		<a href="<?= backend_url ( array( 'bloger' ) ); ?>">
    		    <i class="fa fa-edit"></i>
    		    <span><?= tr ( '_BACKEND_bloger_' ); ?></span>
    		</a>
    	    </li>
	    <?php endif; ?>
	    <?php if ( check_pemission_controller ( 'Gallery' ) ) : ?>
    	    <li<?= is_active ( array( 'gallery' ) ) ?>>
    		<a href="<?= backend_url ( array( 'gallery' ) ); ?>">
    		    <i class="fa fa-image"></i>
    		    <span><?= tr ( '_BACKEND_gallery_' ); ?></span>
    		</a>
    	    </li>
	    <?php endif; ?>

        </ul>
    </section>
</aside>