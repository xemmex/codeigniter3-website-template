<section id="main">
    <div class="wrapper">
	<?php if ( !empty ( $this->settings_model->system['_contact_map_latitude_'] ) && !empty ( $this->settings_model->system['_contact_map_longitude_'] ) ) : ?>
    	<div class="gmap">
    	    <div class="google-map-canvas"
    		 id="contact_us_map"
    		 data-zoom="9"
    		 data-title="<?= $this->settings_model->system['_contact_title_']; ?>"
    		 data-latitude="<?= $this->settings_model->system['_contact_map_latitude_']; ?>"
    		 data-longitude="<?= $this->settings_model->system['_contact_map_longitude_']; ?>">
    	    </div>
    	</div>
	<?php endif; ?>

        <div class="sep" id="form-handler"><span></span></div>

        <h3><?= tr ( '_PAGE_CONTACT_FORM_title_' ); ?></h3>

	<?= form_open ( frontend_url ( array( 'contact' ) ) . '#form-handler', array( 'id' => 'contact_form' ) ); ?>

	<?php if ( isset ( $data['contacto_form_error'] ) && !empty ( $data['contacto_form_error'] ) ) : ?>
    	<div class="message">
    	    <div id="contact_alert" class="alert <?= $data['contacto_form_class']; ?>">
		    <?php echo $data['contacto_form_error']; ?>
    	    </div>
    	</div>
	<?php endif; ?>

	<?= form_label ( tr ( '_GLOBAL_name_' ) . ' :', 'contact_form_name' ); ?>
	<?= form_input ( array( 'name' => 'name', 'value' => set_value ( 'name' ), 'id' => 'contact_form_name', 'class' => 'full-width help', 'title' => tr ( '_GLOBAL_name_' ) ) ); ?>

	<?= form_label ( tr ( '_GLOBAL_email_' ) . ' :', 'contact_form_email' ); ?>
	<?= form_input ( array( 'name' => 'email', 'value' => set_value ( 'email' ), 'id' => 'contact_form_email', 'class' => 'full-width help', 'title' => tr ( '_GLOBAL_email_' ) ) ); ?>

	<?= form_label ( tr ( '_GLOBAL_phone_' ) . ' :', 'contact_form_phone' ); ?>
	<?= form_input ( array( 'name' => 'phone', 'value' => set_value ( 'phone' ), 'id' => 'contact_form_phone', 'class' => 'full-width help', 'title' => tr ( '_GLOBAL_phone_' ) ) ); ?>

	<?= form_label ( tr ( '_GLOBAL_message_' ) . ' :', 'contact_form_message' ); ?>
	<?= form_textarea ( array( 'name' => 'message', 'value' => set_value ( 'message' ), 'id' => 'contact_form_message', 'class' => 'full-width help', 'cols' => '30', 'rows' => '7' ) ); ?>

	<?= form_submit ( array( 'name' => 'contact_form', 'value' => tr ( '_GLOBAL_FORMS_send_' ), 'class' => 'button' ) ); ?>

	<?= form_close (); ?>

        <div class="sep"><span></span></div>

        <h3><?= tr ( '_PAGE_CONTACT_INFO_title_' ); ?></h3>

        <label><?= tr ( '_GLOBAL_phone_' ); ?>:</label>
        <p>
	    <?php if ( !empty ( $this->settings_model->system['_contact_phone_'] ) ) : ?>
		<?= $this->settings_model->system['_contact_phone_']; ?>
	    <?php endif; ?>
	    <?php if ( !empty ( $this->settings_model->system['_contact_mobile_'] ) ) : ?>
    	    <br/><?= $this->settings_model->system['_contact_mobile_']; ?>
	    <?php endif; ?>
        </p>

	<?php if ( !empty ( $this->settings_model->system['_contact_email_'] ) ) : ?>
    	<label><?= tr ( '_GLOBAL_email_' ); ?>:</label>
    	<p><a href="mailto:<?= $this->settings_model->system['_contact_email_']; ?>"><?= $this->settings_model->system['_contact_email_']; ?></a></p>
	<?php endif; ?>

	<?php if ( !empty ( $this->settings_model->system['_contact_skype_'] ) ) : ?>
    	<label><?= tr ( '_GLOBAL_skype_' ); ?>:</label>
    	<p><a href="skype:<?= $this->settings_model->system['_contact_skype_']; ?>?call"><?= $this->settings_model->system['_contact_skype_']; ?></a></p>
	<?php endif; ?>

    </div>
</section>
<?php $this->template->widget ( 'footer' ); ?>
<?php $this->template->widget ( 'gallery', 'gallery_model', 'get_one', 6, 'image' ); ?>