<div class="center">
    <div class="headline text-center"><?= tr ( '_GLOBAL_account_is_locked_' ); ?></div>
    <div class="lockscreen-name"><?= user ( 'name' ); ?> <?= user ( 'lastname' ); ?></div>
    <div class="lockscreen-item">
	<div class="lockscreen-image">
	    <?php $user_avatar = user ( 'avatar' ); ?>
	    <?php if ( !empty ( $user_avatar ) ) : ?>
    	    <img src="<?= $this->template->thumb ( 'uploads', $user_avatar, array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
	    <?php else : ?>
    	    <img src="<?= $this->template->thumb ( 'img', '_avatars/avatar.png', array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
	    <?php endif; ?>
	    <?php unset ( $user_avatar ); ?>
	</div>
	<div class="lockscreen-credentials">
	    <?= form_open ( NULL, array( 'id' => 'locked_form', 'role' => 'form' ) ); ?>
	    <div class="input-group">
		<?=
		form_password ( array(
		    'name' => 'password',
		    'value' => set_value ( 'password' ),
		    'id' => 'password',
		    'class' => 'form-control',
		    'placeholder' => tr ( '_GLOBAL_password_' ),
		) );
		?>
		<div class="input-group-btn">
		    <button class="btn btn-flat"><i class="fa fa-arrow-right text-muted"></i></button>
		</div>
	    </div>
	    <?= form_close (); ?>
	</div>
    </div>
    <div class="lockscreen-link">
	<?php if ( isset ( $data['form_error'] ) && !empty ( $data['form_error'] ) ) : ?>
    	<div class="mb15 alert alert-<?= $data['form_class']; ?>">
    	    <button type="button" class="close" data-hide="alert" aria-hidden="true">×</button>
    	    <div class="form_error"><?= $data['form_error']; ?></div>
    	</div>
	<?php else : ?>
	    <?= tr ( '_GLOBAL_login_with_your_password_' ); ?>
	<?php endif; ?>
	<a href="<?= site_url ( array( 'auth', 'logout' ) ); ?>"><?= tr ( '_GLOBAL_login_with_different_user_' ); ?></a>
    </div>
</div>