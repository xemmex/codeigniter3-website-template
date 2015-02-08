<aside class="right-side">

    <section class="content-header">
        <h1><?= tr ( '_BACKEND_configure_system_' ) ?></h1>
        <div class="pull-right toolbar">
            <a href="<?= backend_url ( array( 'system-settings', 'phpinfo' ) ); ?>" class="btn btn-sm-block btn-success">
                <i class="fa fa-info-circle"></i> <?= tr ( '_BACKEND_phpinfo_' ); ?>
            </a>
        </div>
        <div class="clearfix"></div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-3">
                <ul class="list-group list-group-tabs">
                    <li class="list-group-item active"><a href="#tab_backend_info" data-toggle="tab"><i class="fa fa-cogs"></i> <?= tr ( '_BACKEND_configure_system_info_' ); ?></a></li>
                    <li class="list-group-item"><a href="#tab_backend_users" data-toggle="tab"><i class="fa fa-users"></i> <?= tr ( '_BACKEND_configure_system_users_' ); ?></a></li>
                    <li class="list-group-item"><a href="#tab_backend_theme" data-toggle="tab"><i class="fa fa-image"></i> <?= tr ( '_BACKEND_configure_system_theme_' ); ?></a></li>
                    <li class="list-group-item"><a href="#tab_backend_seo" data-toggle="tab"><i class="fa fa-support"></i> <?= tr ( '_BACKEND_configure_system_seo_' ); ?></a></li>
                    <li class="list-group-item"><a href="#tab_backend_email" data-toggle="tab"><i class="fa fa-envelope"></i> <?= tr ( '_BACKEND_configure_system_mail_' ); ?></a></li>
                </ul>
            </div>
            <div class="col-lg-9">
                <div class="tab-content">

                    <div class="tab-pane active" id="tab_backend_info">

			<?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => '_system_mail_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( '_method', '_system_form' ); ?>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_user_info_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">


                                <div class="form-group">
                                    <label for="_contact_title_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_contact_title_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_contact_title_',
					    'value' => set_value ( '_contact_title_', $this->settings_model->system['_contact_title_'] ),
					    'id' => '_contact_title_',
					    'class' => 'form-control',
					    'tabindex' => '1'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_contact_email_" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_email_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_contact_email_',
					    'value' => set_value ( '_contact_email_', $this->settings_model->system['_contact_email_'] ),
					    'id' => '_contact_email_',
					    'class' => 'form-control',
					    'tabindex' => '2'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_contact_phone_" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_phone_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_contact_phone_',
					    'value' => set_value ( '_contact_phone_', $this->settings_model->system['_contact_phone_'] ),
					    'id' => '_contact_phone_',
					    'class' => 'form-control',
					    'tabindex' => '3'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_contact_address_" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_address_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_contact_address_',
					    'value' => set_value ( '_contact_address_', $this->settings_model->system['_contact_address_'] ),
					    'id' => '_contact_address_',
					    'class' => 'form-control address',
					    'tabindex' => '4'
					) );
					?>
                                        <span
                                            class="alert alert-warning help-block"
                                            data-find-error="<?= tr ( '_GLOBAL_FORMS_address_help_error_' ); ?>"
                                            data-find-success="<?= tr ( '_GLOBAL_FORMS_address_help_success_' ); ?>"
                                            ><?= tr ( '_GLOBAL_FORMS_address_help_' ); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?= tr ( '_GLOBAL_coordinates_' ); ?></label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-sm-6">
						<?=
						form_input ( array(
						    'type' => 'text',
						    'name' => '_contact_map_latitude_',
						    'value' => set_value ( '_contact_map_latitude_', $this->settings_model->system['_contact_map_latitude_'] ),
						    'id' => '_contact_map_latitude_',
						    'class' => 'form-control col-xs-4 latitude',
						    'required' => 'required',
						    'readonly' => 'readonly',
						    'map-type' => 'latitude',
						    'map-id' => 'global-map',
						    'map-address' => '_contact_address_',
						) );
						?>
                                            </div>
                                            <div class="col-sm-6">

						<?=
						form_input ( array(
						    'type' => 'text',
						    'name' => '_contact_map_longitude_',
						    'value' => set_value ( '_contact_map_longitude_', $this->settings_model->system['_contact_map_longitude_'] ),
						    'id' => '_contact_map_longitude_',
						    'class' => 'form-control col-xs-4 longitude',
						    'required' => 'required',
						    'readonly' => 'readonly',
						    'map-type' => 'longitude',
						    'map-id' => 'global-map',
						    'map-address' => '_contact_address_'
						) );
						?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9" >
                                        <div class="google-map-canvas" id="global-map" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_user_social_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="_social_facebook_" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_facebook_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_social_facebook_',
					    'value' => set_value ( '_social_facebook_', $this->settings_model->system['_social_facebook_'] ),
					    'id' => '_social_facebook_',
					    'class' => 'form-control',
					    'tabindex' => '5'
					) );
					?>
                                        <p class="help-block">&raquo; <?= tr ( '_BACKEND_configure_system_seo_socials_help_' ); ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_social_google_plus_" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_google_plus_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_social_google_plus_',
					    'value' => set_value ( '_social_google_plus_', $this->settings_model->system['_social_google_plus_'] ),
					    'id' => '_social_google_plus_',
					    'class' => 'form-control',
					    'tabindex' => '6'
					) );
					?>
                                        <p class="help-block">&raquo; <?= tr ( '_BACKEND_configure_system_seo_socials_help_' ); ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_social_skype_" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_skype_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_social_skype_',
					    'value' => set_value ( '_social_skype_', $this->settings_model->system['_social_skype_'] ),
					    'id' => '_social_skype_',
					    'class' => 'form-control',
					    'tabindex' => '7'
					) );
					?>
                                        <p class="help-block">&raquo; <?= tr ( '_BACKEND_configure_system_seo_socials_help_' ); ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_social_twitter_" class="col-sm-3 control-label"><?= tr ( '_GLOBAL_twitter_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_social_twitter_',
					    'value' => set_value ( '_social_twitter_', $this->settings_model->system['_social_twitter_'] ),
					    'id' => '_social_twitter_',
					    'class' => 'form-control',
					    'tabindex' => '8'
					) );
					?>
                                        <p class="help-block">&raquo; <?= tr ( '_BACKEND_configure_system_seo_socials_help_' ); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_user_footer_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="_system_copyright_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_system_copyright_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_system_copyright_',
					    'value' => set_value ( '_system_copyright_', $this->settings_model->system['_system_copyright_'] ),
					    'id' => '_system_copyright_',
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
                                <button class="btn btn-primary ladda-button" data-style="expand-left">
                                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                                </button>
                            </div>
			    <?= form_close (); ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_backend_users">

			<?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => '_system_mail_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( '_method', '_system_users_form' ); ?>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_system_users_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="_user_login_max_attemps_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_login_max_attemps_' ); ?></label>

                                    <div class="col-sm-2">
					<?=
					form_input ( array(
					    'type' => 'number',
					    'maxlength' => 1,
					    'min' => 1,
					    'max' => 5,
					    'name' => '_user_login_max_attemps_',
					    'value' => set_value ( '_user_login_max_attemps_', $this->settings_model->system['_user_login_max_attemps_'] ),
					    'id' => '_user_login_max_attemps_',
					    'class' => 'form-control',
					    'required' => 'required',
					    'disabled' => 'disabled'
					) );
					?>

                                    </div>
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <p class="help-block text-danger"><?= tr ( '_BACKEND_function_not_available_' ); ?></p>
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="_user_login_captcha_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_login_captcha_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_user_login_captcha_" id="_user_login_captcha_" class="form-control" disabled="disabled">
                                            <option value="0" <?= set_select ( '_user_login_captcha_', '0', (( int ) $this->settings_model->system['_user_login_captcha_'] === 0 ) ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( '_user_login_captcha_', '1', (( int ) $this->settings_model->system['_user_login_captcha_'] === 1 ) ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>
                                        <p class="help-block text-danger"><?= tr ( '_BACKEND_function_not_available_' ); ?></p>

                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="_user_login_enabled_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_login_enabled_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_user_login_enabled_" id="_user_login_enabled_" class="form-control" disabled="disabled">
                                            <option value="0" <?= set_select ( '_user_login_enabled_', '0', (( int ) $this->settings_model->system['_user_login_enabled_'] === 0 ) ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( '_user_login_enabled_', '1', (( int ) $this->settings_model->system['_user_login_enabled_'] === 1 ) ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>
                                        <p class="help-block text-danger"><?= tr ( '_BACKEND_function_not_available_' ); ?></p>

                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="_user_forgot_enabled_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_forgot_enabled_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_user_forgot_enabled_" id="_user_forgot_enabled_" class="form-control" disabled="disabled">
                                            <option value="0" <?= set_select ( '_user_forgot_enabled_', '0', (( int ) $this->settings_model->system['_user_forgot_enabled_'] === 0 ) ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( '_user_forgot_enabled_', '1', (( int ) $this->settings_model->system['_user_forgot_enabled_'] === 1 ) ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>
                                        <p class="help-block text-danger"><?= tr ( '_BACKEND_function_not_available_' ); ?></p>

                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="_user_register_enabled_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_register_enabled_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_user_register_enabled_" id="_user_register_enabled_" class="form-control" disabled="disabled">
                                            <option value="0" <?= set_select ( '_user_register_enabled_', '0', (( int ) $this->settings_model->system['_user_register_enabled_'] === 0 ) ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( '_user_register_enabled_', '1', (( int ) $this->settings_model->system['_user_register_enabled_'] === 1 ) ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>
                                        <p class="help-block text-danger"><?= tr ( '_BACKEND_function_not_available_' ); ?></p>

                                    </div>
                                </div>

                                <div class="form-group" data-parent="_user_register_enabled_" >
                                    <label for="_user_register_automatic_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_register_automatic_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_user_register_automatic_" id="_user_register_automatic_" class="form-control">
                                            <option value="0" <?= set_select ( '_user_register_automatic_', '0', (( int ) $this->settings_model->system['_user_register_automatic_'] === 0 ) ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( '_user_register_automatic_', '1', (( int ) $this->settings_model->system['_user_register_automatic_'] === 1 ) ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>

			<div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_system_users_locked_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group" >
                                    <label for="_user_locked_status_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_locked_status_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_user_locked_status_" id="_user_login_captcha_" class="form-control">
                                            <option value="0" <?= set_select ( '_user_locked_status_', '0', (( int ) $this->settings_model->system['_user_locked_status_'] === 0 ) ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( '_user_locked_status_', '1', (( int ) $this->settings_model->system['_user_locked_status_'] === 1 ) ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>
                                    </div>
                                </div>

				<div class="form-group">
                                    <label for="_user_locked_timeout_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_user_locked_timeout_' ); ?></label>

                                    <div class="col-sm-2">
					<?=
					form_input ( array(
					    'type' => 'number',
					    'maxlength' => 1,
					    'min' => 1,
					    'max' => 30,
					    'name' => '_user_locked_timeout_',
					    'value' => set_value ( '_user_locked_timeout_', $this->settings_model->system['_user_locked_timeout_'] ),
					    'id' => '_user_locked_timeout_',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>

                                    </div>

				    <div class="col-sm-9 col-sm-offset-3">
                                        <p class="help-block"><?= tr ( '_BACKEND_configure_system_user_locked_timeout_help_' ); ?> --> 5 ~ 30</p>
                                    </div>

                                </div>


                                <div class="form-group header hidden panel-alert">
                                    <div class="col-md-12 form_error">

                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">
                                <button class="btn btn-primary ladda-button" data-style="expand-left">
                                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                                </button>
                            </div>
			    <?= form_close (); ?>

                        </div>


                    </div>

                    <div class="tab-pane" id="tab_backend_seo">

			<?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => '_system_mail_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( '_method', '_system_seo_form' ); ?>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_system_seo_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">


                                <div class="form-group">
                                    <label for="_seo_title_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_seo_title_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_seo_title_',
					    'value' => set_value ( '_seo_title_', $this->settings_model->system['_seo_title_'] ),
					    'id' => '_seo_title_',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_seo_keywords_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_seo_keywords_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_seo_keywords_',
					    'value' => set_value ( '_seo_keywords_', $this->settings_model->system['_seo_keywords_'] ),
					    'id' => '_seo_keywords_',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_seo_description_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_seo_description_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_textarea ( array(
					    'name' => '_seo_description_',
					    'value' => set_value ( '_seo_description_', $this->settings_model->system['_seo_description_'] ),
					    'id' => '_seo_description_',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_seo_google_analytics_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_seo_google_analytics_' ); ?></label>
                                    <div class="col-sm-9">
					<?=
					form_textarea ( array(
					    'name' => '_seo_google_analytics_',
					    'value' => set_value ( '_seo_google_analytics_', $this->settings_model->system['_seo_google_analytics_'] ),
					    'id' => '_seo_google_analytics_',
					    'class' => 'form-control'
					) );
					?>
                                        <p class="help-block">&raquo; <?= tr ( '_BACKEND_configure_system_seo_google_analytics_help_' ); ?></p>
                                    </div>
                                </div>

                                <div class="form-group header hidden panel-alert">
                                    <div class="col-md-12 form_error">

                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">
                                <button class="btn btn-primary ladda-button" data-style="expand-left">
                                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                                </button>
                            </div>
			    <?= form_close (); ?>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_backend_theme">

			<?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => '_system_mail_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( '_method', '_system_theme_form' ); ?>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_system_theme_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">


                                <div class="form-group">
                                    <label for="_system_frontend_theme_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_frontend_theme_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_system_theme_frontend_" id="_system_theme_frontend_" class="form-control" disabled="disabled">
                                            <option value="default" <?= set_select ( '_system_theme_frontend_', 'default', ($this->settings_model->system['_system_theme_frontend_'] == 'default' ) ); ?> >Default</option>
                                        </select>
                                        <p class="help-block text-danger"><?= tr ( '_BACKEND_function_not_available_' ); ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_system_frontend_theme_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_backend_theme_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_system_theme_backend_" id="_system_theme_backend_" class="form-control"  disabled="disabled">
                                            <option value="default" <?= set_select ( '_system_theme_backend_', 'default', ($this->settings_model->system['_system_theme_backend_'] == 'default' ) ); ?> >Default</option>
                                        </select>
                                        <p class="help-block text-danger"><?= tr ( '_BACKEND_function_not_available_' ); ?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_system_theme_backend_style_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_backend_theme_style_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_system_theme_backend_style_" id="_system_theme_backend_style_" class="form-control" >
                                            <option value="skin-blue" <?= set_select ( '_system_theme_backend_style_', 'skin-blue', ($this->settings_model->system['_system_theme_backend_style_'] == 'skin-blue' ) ); ?> >Azul</option>
                                            <option value="skin-blue fixed" <?= set_select ( '_system_theme_backend_style_', 'skin-blue fixed', ($this->settings_model->system['_system_theme_backend_style_'] == 'skin-blue fixed' ) ); ?> >Azul -  Fixed</option>
                                            <option value="skin-black" <?= set_select ( '_system_theme_backend_style_', 'skin-black', ($this->settings_model->system['_system_theme_backend_style_'] == 'skin-black' ) ); ?> >Negro</option>
                                            <option value="skin-black fixed" <?= set_select ( '_system_theme_backend_style_', 'skin-black fixed', ($this->settings_model->system['_system_theme_backend_style_'] == 'skin-black fixed' ) ); ?> >Negro - Fixed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_images_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="_system_image_not_available_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_image_not_available_' ); ?></label>
                                    <div class="col-sm-9">
                                        <div class="btn-group pr5">

                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                <img src="<?= $this->template->thumb ( 'uploads', $this->settings_model->system['_system_image_not_available_'], array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="watermark">				</div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 100px; height: 100px;"></div>
                                            <div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileinput-new"><?= tr ( '_GLOBAL_change_' ); ?></span>
                                                    <span class="fileinput-exists"><?= tr ( '_GLOBAL_change_' ); ?></span>

                                                    <input type="file" name="_system_image_not_available_">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <p class="help-block">GIF | JPG | JPEG | PNG &raquo; 500 KB</p>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_system_watermak_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group" >
                                    <label for="_system_image_watermark_status_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_system_image_watermark_status_' ); ?></label>

                                    <div class="col-sm-5">
                                        <select name="_system_image_watermark_status_" id="_system_image_watermark_status_" class="form-control">
                                            <option value="0" <?= set_select ( '_system_image_watermark_status_', '0', (( int ) $this->settings_model->system['_system_image_watermark_status_'] === 0 ) ); ?> ><?= tr ( '_GLOBAL_disabled_' ); ?></option>
                                            <option value="1" <?= set_select ( '_system_image_watermark_status_', '1', (( int ) $this->settings_model->system['_system_image_watermark_status_'] === 1 ) ); ?> ><?= tr ( '_GLOBAL_enabled_' ); ?></option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group" data-parent="_system_image_watermark_status_">
                                    <label for="_system_image_watermark_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_system_image_watermark_' ); ?></label>

                                    <div class="col-sm-9">
                                        <div class="btn-group pr5">

                                        </div>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                <img src="<?= $this->template->thumb ( 'uploads', $this->settings_model->system['_system_image_watermark_'], array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) ?>" alt="watermark">				</div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 100px; height: 100px;"></div>
                                            <div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileinput-new"><?= tr ( '_GLOBAL_change_' ); ?></span>
                                                    <span class="fileinput-exists"><?= tr ( '_GLOBAL_change_' ); ?></span>

                                                    <input type="file" name="_system_image_watermark_">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <p class="help-block">PNG &raquo; 500 KB</p>
                                    </div>
                                </div>


                                <div class="form-group" data-parent="_system_image_watermark_status_">
                                    <label for="_system_image_watermark_position_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_system_image_watermark_position_' ); ?></label>

                                    <div class="col-sm-2">
                                        <select name="_system_image_watermark_position_" id="_system_image_watermark_position_" class="form-control">
                                            <option value="1" <?= set_select ( '_system_image_watermark_position_', '1', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 1 ) ); ?> >1</option>
                                            <option value="2" <?= set_select ( '_system_image_watermark_position_', '2', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 2 ) ); ?> >2</option>
                                            <option value="3" <?= set_select ( '_system_image_watermark_position_', '3', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 3 ) ); ?> >3</option>
                                            <option value="4" <?= set_select ( '_system_image_watermark_position_', '4', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 4 ) ); ?> >4</option>
                                            <option value="5" <?= set_select ( '_system_image_watermark_position_', '5', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 5 ) ); ?> >5</option>
                                            <option value="6" <?= set_select ( '_system_image_watermark_position_', '6', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 6 ) ); ?> >6</option>
                                            <option value="7" <?= set_select ( '_system_image_watermark_position_', '7', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 7 ) ); ?> >7</option>
                                            <option value="8" <?= set_select ( '_system_image_watermark_position_', '8', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 8 ) ); ?> >8</option>
                                            <option value="9" <?= set_select ( '_system_image_watermark_position_', '9', (( int ) $this->settings_model->system['_system_image_watermark_position_'] === 9 ) ); ?> >9</option>
                                        </select>

                                    </div>
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <p class="help-block"><?= tr ( '_BACKEND_configure_system_system_image_watermark_position_help_' ) ?></p>
                                    </div>
                                </div>

                                <div class="form-group" data-parent="_system_image_watermark_status_">
                                    <label for="_system_image_watermark_transparency_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_system_image_watermark_transparency_' ); ?></label>

                                    <div class="col-sm-2">
					<?=
					form_input ( array(
					    'type' => 'number',
					    'maxlength' => 3,
					    'min' => 0,
					    'max' => 100,
					    'name' => '_system_image_watermark_transparency_',
					    'value' => set_value ( '_system_image_watermark_transparency_', $this->settings_model->system['_system_image_watermark_transparency_'] ),
					    'id' => '_system_image_watermark_transparency_',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>

                                    </div>
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <p class="help-block"><?= tr ( '_BACKEND_configure_system_system_image_watermark_transparency_help_' ) ?></p>
                                    </div>
                                </div>

                                <div class="form-group header hidden panel-alert">
                                    <div class="col-md-12 form_error">

                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">
                                <button class="btn btn-primary ladda-button" data-style="expand-left">
                                    <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_update_' ); ?></span>
                                </button>
                            </div>
			    <?= form_close (); ?>
                        </div>

                    </div>

                    <div class="tab-pane" id="tab_backend_email">

			<?= form_open ( NULL, array( 'class' => 'form-horizontal form-bordered form-ajax', 'id' => '_system_mail_form', 'role' => 'form' ) ); ?>
			<?= form_hidden ( '_method', '_system_mail_form' ); ?>


                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_mail_info_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="_mail_from_email_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_from_email_' ); ?></label>
                                    <div class="col-sm-5">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_mail_from_email_',
					    'value' => set_value ( '_mail_from_email_', $this->settings_model->system['_mail_from_email_'] ),
					    'id' => '_mail_from_email_',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_mail_from_name_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_from_name_' ); ?></label>
                                    <div class="col-sm-5">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_mail_from_name_',
					    'value' => set_value ( '_mail_from_name_', $this->settings_model->system['_mail_from_name_'] ),
					    'id' => '_mail_from_name_',
					    'class' => 'form-control',
					    'required' => 'required'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="_mail_mailtype_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_mailtype_' ); ?></label>
                                    <div class="col-sm-2">
                                        <select name="_mail_mailtype_" id="email_protocol" class="form-control">
                                            <option value="html" <?= set_select ( '_mail_mailtype_', 'html', ($this->settings_model->system['_mail_mailtype_'] == 'html' ) ); ?> >html</option>
                                            <option value="text" <?= set_select ( '_mail_mailtype_', 'text', ($this->settings_model->system['_mail_mailtype_'] == 'text' ) ); ?> >text</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="box box-solid box-black">

                            <div class="box-header">
                                <div class="col-md-12">
                                    <h3 class="box-title"><?= tr ( '_BACKEND_configure_system_mail_settings_title_' ) ?></h3>
                                </div>
                            </div>

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="_mail_protocol_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_protocol_' ); ?></label>
                                    <div class="col-sm-5">
                                        <select name="_mail_protocol_" id="_mail_protocol_" class="form-control">
                                            <option value="mail" <?= set_select ( '_mail_protocol_', 'mail', ($this->settings_model->system['_mail_protocol_'] == 'mail' ) ); ?> >MAIL (internal email function)</option>
                                            <option value="smtp" <?= set_select ( '_mail_protocol_', 'smtp', ($this->settings_model->system['_mail_protocol_'] == 'smtp' ) ); ?> >SMTP (external email server)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" data-parent="_mail_protocol_">
                                    <label for="_mail_smtp_host_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_smtp_host_' ); ?></label>
                                    <div class="col-sm-5">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_mail_smtp_host_',
					    'value' => set_value ( '_mail_smtp_host_', $this->settings_model->system['_mail_smtp_host_'] ),
					    'id' => '_mail_smtp_host_',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group" data-parent="_mail_protocol_">
                                    <label for="_mail_smtp_user_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_smtp_user_' ); ?></label>
                                    <div class="col-sm-4">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_mail_smtp_user_',
					    'value' => set_value ( '_mail_smtp_user_', $this->settings_model->system['_mail_smtp_user_'] ),
					    'id' => '_mail_smtp_user_',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group" data-parent="_mail_protocol_">
                                    <label for="_mail_smtp_pass_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_smtp_pass_' ); ?></label>
                                    <div class="col-sm-4">
					<?=
					form_password ( array(
					    'type' => 'text',
					    'name' => '_mail_smtp_pass_',
					    'value' => set_value ( '_mail_smtp_pass_', $this->settings_model->system['_mail_smtp_pass_'] ),
					    'id' => '_mail_smtp_pass_',
					    'class' => 'form-control'
					) );
					?>
                                    </div>
                                </div>

                                <div class="form-group" data-parent="_mail_protocol_">
                                    <label for="_mail_smtp_port_" class="col-sm-3 control-label"><?= tr ( '_BACKEND_configure_system_mail_smtp_port_' ); ?></label>
                                    <div class="col-sm-2">
					<?=
					form_input ( array(
					    'type' => 'text',
					    'name' => '_mail_smtp_port_',
					    'value' => set_value ( '_mail_smtp_port_', $this->settings_model->system['_mail_smtp_port_'] ),
					    'id' => '_mail_smtp_port_',
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