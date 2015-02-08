<div class="modal fade" id="user-add-modal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content box box-solid box-primary">

            <div class="modal-header box-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title"><?= tr ( '_BACKEND_add_user_' ) ?></h3>
            </div>

	    <?= form_open ( 'backend/users/add', array( 'class' => 'form-horizontal form-ajax', 'id' => '_add_user_form', 'role' => 'form' ) ); ?>

            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label"><?= tr ( '_GLOBAL_name_' ); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
			    <?=
			    form_input ( array(
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
                    <label for="lastname" class="col-sm-4 control-label"><?= tr ( '_GLOBAL_lastname_' ); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
			    <?=
			    form_input ( array(
				'type' => 'text',
				'name' => 'lastname',
				'value' => set_value ( 'lastname' ),
				'id' => 'lastname',
				'class' => 'form-control',
				'required' => 'required'
			    ) );
			    ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label"><?= tr ( '_GLOBAL_email_' ); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
			    <?=
			    form_input ( array(
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

                <div class="form-group">
                    <label for="email_repeat" class="col-sm-4 control-label"><?= tr ( '_GLOBAL_email_repeat_' ); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
			    <?=
			    form_input ( array(
				'type' => 'email',
				'name' => 'email_repeat',
				'value' => set_value ( 'email_repeat' ),
				'id' => 'email_repeat',
				'class' => 'form-control',
				'required' => 'required'
			    ) );
			    ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label"><?= tr ( '_GLOBAL_password_' ); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
			    <?=
			    form_password ( array(
				'name' => 'password',
				'value' => set_value ( 'password' ),
				'id' => 'password',
				'class' => 'form-control',
				'required' => 'required'
			    ) );
			    ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_repeat" class="col-sm-4 control-label"><?= tr ( '_GLOBAL_password_repeat_' ); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
			    <?=
			    form_password ( array(
				'name' => 'password_repeat',
				'value' => set_value ( 'password_repeat' ),
				'id' => 'password',
				'class' => 'form-control',
				'required' => 'required'
			    ) );
			    ?>
                        </div>
                    </div>
                </div>
                <div class="form-group header hidden panel-alert">
                    <div class="col-md-12 form_error">

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

