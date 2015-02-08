<div class="form-box" id="login-box">
    <div class="header"><?= tr ( '_BACKEND_AUTH_LOGIN_title_' ) ?></div>

    <?= form_open ( NULL, array ( 'id' => 'login_form', 'role' => 'form' ) ); ?>

    <div class="body bg-gray">

        <div class="form-group <?= isset ( $data['form_error_class']['email'] ) ? $data['form_error_class']['email'] : ''; ?>">
            <?php
            $input_email = array (
                'name' => 'email',
                'value' => set_value ( 'email' ),
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => tr ( '_GLOBAL_email_' ),
                'type' => 'email',
                'required' => 'required',
                'autofocus' => 'autofocus'
            );
            echo form_input ( $input_email );
            ?>
        </div>

        <div class="form-group <?= isset ( $data['form_error_class']['password'] ) ? $data['form_error_class']['password'] : ''; ?>">
            <?php
            $input_password = array (
                'name' => 'password',
                'value' => set_value ( 'password' ),
                'id' => 'password',
                'class' => 'form-control',
                'placeholder' => tr ( '_GLOBAL_password_' ),
            );
            echo form_password ( $input_password );
            ?>
        </div>

        <div class="form-group">

            <input type="checkbox" name="remember" id="remember" value="1" <?= set_checkbox ( 'remember', '1' ); ?> />
            <?= tr ( '_GLOBAL_FORMS_remember_' ) ?>
        </div>
    </div>
    <div class="footer">

        <?php if ( isset ( $data['form_error'] ) && !empty ( $data['form_error'] ) ) : ?>

            <div class="mb15 alert alert-<?= $data['form_class']; ?>">
                <button type="button" class="close" data-hide="alert" aria-hidden="true">×</button>
                <div class="form_error"><?= $data['form_error']; ?></div>
            </div>
        <?php endif; ?>

        <button class="btn btn-lg bg-olive btn-block ladda-button" data-style="zoom-out" type="submit">
            <span class="ladda-label"><?= tr ( '_GLOBAL_FORMS_login_' ); ?></span>
        </button>

        <?php if ( ( bool ) $this->settings_model->system['_user_forgot_enabled_'] === TRUE ) : ?>
            <p><a href="<?= backend_url ( array ( 'auth', 'forgot' ) ); ?>" class="text-center"><?= tr ( '_BACKEND_AUTH_forgot_password_' ) ?></a></p>
        <?php endif; ?>
        <?php if ( ( bool ) $this->settings_model->system['_user_register_enabled_'] === TRUE ) : ?>
            <a href="<?= backend_url ( array ( 'auth', 'register' ) ); ?>" class="text-center"><?= tr ( '_BACKEND_AUTH_register_' ) ?></a>
        <?php endif; ?>
    </div>


    <?= form_close (); ?>
    <div class="margin text-center">
        <a href="<?= frontend_url (); ?>"><i class="glyphicon glyphicon-arrow-left"></i> <?= tr ( '_BACKEND_go_frontend_' ) ?></a>
    </div>
</div>