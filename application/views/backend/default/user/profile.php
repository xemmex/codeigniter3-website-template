<aside class="right-side">

    <section class="content-header">
        <h1><?= tr ( '_GLOBAL_my_profile_' ) ?></h1>
        <div class="clearfix"></div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-lg-3">
                <ul class="list-group list-group-tabs">
                    <li class="list-group-item active"><a href="#tab_user_profile_form" data-toggle="tab"><i class="fa fa-user"></i> <?= tr ( '_GLOBAL_basic_info_' ); ?></a></li>
                    <li class="list-group-item"><a href="#tab_user_info_form" data-toggle="tab"><i class="fa fa-archive"></i> <?= tr ( '_GLOBAL_extra_info_' ); ?></a></li>
                    <li class="list-group-item"><a href="#tab_user_password_form" data-toggle="tab"><i class="fa fa-key"></i> <?= tr ( '_GLOBAL_change_password_' ); ?></a></li>
                </ul>

                <hr>

                <ul class="list-table">
                    <li style="width:70px;">
			<?php $user_avatar = user ( 'avatar' ); ?>
			<?php if ( !empty ( $user_avatar ) ) : ?>
    			<img src="<?= $this->template->thumb ( 'uploads', $user_avatar, array( 'w' => 68, 'h' => 68, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle img-bordered">
			<?php else : ?>
    			<img src="<?= $this->template->thumb ( 'img', '_avatars/avatar.png', array( 'w' => 68, 'h' => 68, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle img-bordered">
			<?php endif; ?>
                    </li>
                    <li class="text-left">
		    <h5 class="semibold ellipsis mt0"><?= user ( 'name' ); ?> <?= user ( 'lastname' ); ?></h5>
		    <div style="max-width:200px;">
			<div class="progress progress-md mb5">
			    <?php if ( user ( 'status' ) == 1 ) : ?>
    			    <div class="progress-bar progress-bar-success" style="width:100%;"><?= tr ( '_GLOBAL' . user ( 'status_text' ) ); ?></div>
			    <?php else: ?>
    			    <div class="progress-bar progress-bar-danger" style="width:100%"><?= tr ( '_GLOBAL' . user ( 'status_text' ) ); ?></div>
			    <?php endif; ?>
			</div>
			<div class="progress progress-md mb5">
			    <?php if ( user ( 'permissions' ) == 1 ): ?>
    			    <div class="progress-bar progress-bar-primary" style="width:100%;"><?= tr ( '_GLOBAL' . user ( 'permission_text' ) ); ?></div>
			    <?php elseif ( user ( 'permissions' ) == 5 ): ?>
    			    <div class="progress-bar progress-bar-danger" style="width:100%;"><?= tr ( '_GLOBAL' . user ( 'permission_text' ) ); ?></div>
			    <?php else : ?>
    			    <div class="progress-bar progress-bar-warning" style="width:100%;"><?= tr ( '_GLOBAL' . user ( 'permission_text' ) ); ?></div>
			    <?php endif; ?>
			</div>

		    </div>
                    </li>
                </ul>

                <hr>

                <ul class="nav nav-section nav-justified mt15">
                    <li>
                        <div class="section">
                            <h4 class="semibold"><?= tr ( '_GLOBAL_date_register_' ); ?></h4>
                            <p class="mt10 text-muted"><?= date ( 'd/m/Y H:i', strtotime ( user ( 'fecha_register' ) ) ); ?></p>
                        </div>
                    </li>
                    <li>
                        <div class="section">
                            <h4 class="semibold"><?= tr ( '_GLOBAL_date_login_' ); ?></h4>
                            <p class="mt10 text-muted"><?= date ( 'd/m/Y H:i', strtotime ( user ( 'fecha_login' ) ) ); ?></p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9">

                <div class="tab-content">

                    <div class="tab-pane active" id="tab_user_profile_form">

			<?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => 'user_profile_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( 'user_profile_form', TRUE ); ?>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_GLOBAL_basic_info_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_name_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => 'name',
					    'value' => set_value ( 'name', user ( 'name' ) ),
					    'id' => 'name',
					    'class' => 'form-control',
					    'required' => 'required',
					    'autofocus' => 'autofocus'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="lastname" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_lastname_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => 'lastname',
					    'value' => set_value ( 'lastname', user ( 'lastname' ) ),
					    'id' => 'lastname',
					    'class' => 'form-control',
					    'required' => 'required',
					    'autofocus' => 'autofocus'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_email_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'email',
					    'name' => 'email',
					    'value' => set_value ( 'email', user ( 'email' ) ),
					    'id' => 'email',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_repeat" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_email_repeat_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'email',
					    'name' => 'email_repeat',
					    'value' => set_value ( 'email_repeat', user ( 'email' ) ),
					    'id' => 'email_repeat',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_GLOBAL_language_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="language" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_language_' ); ?></label>
                                    <div class="col-sm-5">
                                        <select name="language" id="language" class="form-control">
					    <?php foreach ( $this->settings_model->languages as $lang ) : ?>
    					    <option value="<?= $lang['uID'] ?>" <?= set_select ( 'language', $lang['uID'], ($lang['uID'] == user ( 'language' ) ) ); ?> ><?= $lang['text'] ?></option>
					    <?php endforeach; ?>
					    <?php unset ( $lang ); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group header hidden panel-alert">
                                    <div class="col-md-12 form_error">

                                    </div>
                                </div>

                            </div>
                            <div class="box-footer">
                                <button class="btn btn-default" type="reset"><?= tr ( '_GLOBAL_FORMS_reset_' ); ?></button>
                                <button class="btn btn-primary ladda-button" data-style="expand-left">
                                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                                </button>
                            </div>

			    <?= form_close (); ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_user_info_form">

			<?= form_open_multipart ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => 'user_info_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( 'user_info_form', TRUE ); ?>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_GLOBAL_extra_info_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_avatar_' ); ?></label>
                                    <div class="col-sm-9">
                                        <div class="btn-group pr5">

                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
						<?php if ( !empty ( $user_avatar ) ) : ?>
    						<img src="<?= $this->template->thumb ( 'uploads', $user_avatar, array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
						<?php else : ?>
    						<img src="<?= $this->template->thumb ( 'img', '_avatars/avatar.png', array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="user_avatar" class="img-circle">
						<?php endif; ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 100px; height: 100px;"></div>
                                            <div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileinput-new"><?= tr ( '_GLOBAL_change_' ); ?></span>
                                                    <span class="fileinput-exists"><?= tr ( '_GLOBAL_change_' ); ?></span>

                                                    <input type="file" name="avatar">
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cargo" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_cargo_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => 'cargo',
					    'value' => set_value ( 'cargo', user ( 'cargo' ) ),
					    'id' => 'cargo',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vat" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_vat_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => 'vat',
					    'value' => set_value ( 'vat', user ( 'vat' ) ),
					    'id' => 'vat',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile_phone" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_mobile_phone_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'tel',
					    'name' => 'mobile_phone',
					    'value' => set_value ( 'mobile_phone', user ( 'mobile_phone' ) ),
					    'id' => 'mobile_phone',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_phone_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'tel',
					    'name' => 'phone',
					    'value' => set_value ( 'phone', user ( 'phone' ) ),
					    'id' => 'phone',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fax" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_fax_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'tel',
					    'name' => 'fax',
					    'value' => set_value ( 'fax', user ( 'fax' ) ),
					    'id' => 'fax',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_address_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => 'address',
					    'value' => set_value ( 'address', user ( 'address' ) ),
					    'id' => 'address',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_description_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_textarea ( array(
					    'name' => 'description',
					    'value' => set_value ( 'description', user ( 'description' ) ),
					    'id' => 'description',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group header hidden panel-alert">
                                    <div class="col-md-12 form_error">

                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-default" type="reset"><?= tr ( '_GLOBAL_FORMS_reset_' ); ?></button>
                                <button class="btn btn-primary ladda-button" data-style="expand-left">
                                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                                </button>
                            </div>
			    <?= form_close (); ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_user_password_form">

			<?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => 'user_password_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( 'user_password_form', TRUE ); ?>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_GLOBAL_change_password_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="old_password" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_old_password_' ); ?></label>
                                    <div class="col-sm-5">
					<?=
					form_password ( array(
					    'name' => 'old_password',
					    'value' => set_value ( 'old_password' ),
					    'id' => 'old_password',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
					<?php if ( ( bool ) $this->settings_model->system['_user_forgot_enabled_'] === TRUE ) : ?>
    					<p class="help-block"><a href="<?= backend_url ( array( 'auth', 'forgot' ) ); ?>"><?= tr ( '_PAGE_AUTH_SIDEBAR_LINKS_forgot_' ) ?></a></p>
					<?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="new_password" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_new_password_' ); ?></label>
                                    <div class="col-sm-5">
					<?=
					form_password ( array(
					    'name' => 'new_password',
					    'value' => set_value ( 'new_password' ),
					    'id' => 'new_password',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_new_password_repeat_' ); ?></label>
                                    <div class="col-sm-5">
					<?=
					form_password ( array(
					    'name' => 'new_password_repeat',
					    'value' => set_value ( 'new_password_repeat' ),
					    'id' => 'new_password_repeat',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group header hidden panel-alert">
                                    <div class="col-md-12 form_error">

                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-default" type="reset"><?= tr ( '_GLOBAL_FORMS_reset_' ); ?></button>
                                <button class="btn btn-primary ladda-button" data-style="expand-left">
                                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                                </button>
                            </div>
			    <?= form_close (); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>