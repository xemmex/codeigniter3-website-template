<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class System_settings extends Backend_Controller
{

    public function index ()
    {
	if ( $this->input->is_ajax_request () )
	{
	    $method = $this->input->post ( '_method' );

	    if ( isset ( $method ) && method_exists ( $this, $method ) )
	    {
		self::$method ();
	    }
	    else
	    {
		show_404 ();
	    }
	}
	else
	{

	    $data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	    $this->template
		    ->set ( 'js', '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?&sensor=true"></script>', TRUE )
		    ->set ( 'js', array( 'system_settings/index' => '20140805' ) )
		    ->set ( 'views', 'system_settings/index' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    public function phpinfo ()
    {
	$data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_PHPINFO_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_PHPINFO_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_PHPINFO_title_' );

	$this->template
		->set ( 'views', 'system_settings/phpinfo' )
		->set ( 'data', $data )
		->render ();
    }

    private function _system_form ()
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( '_contact_title_', '"' . tr ( '_BACKEND_configure_system_contact_title_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_contact_email_', '"' . tr ( '_GLOBAL_email_' ) . '"', 'required|valid_email|trim' );
	$this->form_validation->set_rules ( '_contact_phone_', '"' . tr ( '_GLOBAL_phone_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_contact_address_', '"' . tr ( '_GLOBAL_address_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_contact_map_latitude_', '"' . tr ( '_GLOBAL_latitude_' ) . '"', 'required|decimal|trim' );
	$this->form_validation->set_rules ( '_contact_map_longitude_', '"' . tr ( '_GLOBAL_longitude_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_social_facebook_', '"' . tr ( '_GLOBAL_facebook_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( '_social_google_plus_', '"' . tr ( '_GLOBAL_google_plus_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( '_social_skype_', '"' . tr ( '_GLOBAL_skype_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( '_social_twitter_', '"' . tr ( '_GLOBAL_twitter_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( '_system_copyright_', '"' . tr ( '_BACKEND_configure_system_system_copyright_' ) . '"', 'required|trim' );

	// Return Data
	$json = array(
	    'csrf' => array(
		$this->security->get_csrf_token_name () => $this->security->get_csrf_hash ()
	    )
	);

	// Check Validation
	if ( !$this->form_validation->run () )
	{
	    $json['status'] = FALSE;
	    $json['message'] = validation_errors ();
	    $json['rules'] = array(
		'_contact_title_' => form_error ( '_contact_title_' ) ? 'has-error' : 'has-success',
		'_contact_email_' => form_error ( '_contact_email_' ) ? 'has-error' : 'has-success',
		'_contact_phone_' => form_error ( '_contact_phone_' ) ? 'has-error' : 'has-success',
		'_contact_address_' => form_error ( '_contact_address_' ) ? 'has-error' : 'has-success',
		'_contact_map_latitude_' => form_error ( '_contact_map_latitude_' ) ? 'has-error' : 'has-success',
		'_contact_map_longitude_' => form_error ( '_contact_map_longitude_' ) ? 'has-error' : 'has-success',
		'_social_facebook_' => form_error ( '_social_facebook_' ) ? 'has-error' : 'has-success',
		'_social_google_plus_' => form_error ( '_social_google_plus_' ) ? 'has-error' : 'has-success',
		'_social_skype_' => form_error ( '_social_skype_' ) ? 'has-error' : 'has-success',
		'_social_twitter_' => form_error ( '_social_twitter_' ) ? 'has-error' : 'has-success',
		'_system_copyright_' => form_error ( '_system_copyright_' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    // Load library
	    $this->load->model ( 'backend/system_settings_model' );

	    // Form Values
	    $form['_contact_title_'] = $this->input->post ( '_contact_title_', TRUE );
	    $form['_contact_email_'] = $this->input->post ( '_contact_email_', TRUE );
	    $form['_contact_phone_'] = $this->input->post ( '_contact_phone_', TRUE );
	    $form['_contact_address_'] = $this->input->post ( '_contact_address_', TRUE );
	    $form['_contact_map_latitude_'] = $this->input->post ( '_contact_map_latitude_', TRUE );
	    $form['_contact_map_longitude_'] = $this->input->post ( '_contact_map_longitude_', TRUE );

	    $form['_social_facebook_'] = $this->input->post ( '_social_facebook_', TRUE );
	    $form['_social_google_plus_'] = $this->input->post ( '_social_google_plus_', TRUE );
	    $form['_social_skype_'] = $this->input->post ( '_social_skype_', TRUE );
	    $form['_social_twitter_'] = $this->input->post ( '_social_twitter_', TRUE );
	    $form['_system_copyright_'] = $this->input->post ( '_system_copyright_', TRUE );

	    // Check if user can login
	    if ( $this->system_settings_model->update ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_SUCCESS_update_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_ERROR_update_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    private function _system_users_form ()
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	//$this->form_validation->set_rules ( '_user_login_max_attemps_', '"' . tr ( '_BACKEND_configure_system_user_login_max_attemps_' ) . '"', 'required|trim|numeric|max_length[1]|less_than[6]|greater_than[0]' );
	//$this->form_validation->set_rules ( '_user_login_captcha_', '"' . tr ( '_BACKEND_configure_system_user_login_captcha_' ) . '"', 'required|trim' );
	//$this->form_validation->set_rules ( '_user_register_enabled_', '"' . tr ( '_BACKEND_configure_system_user_register_enabled_' ) . '"', 'required|trim' );
	//$this->form_validation->set_rules ( '_user_register_automatic_', '"' . tr ( '_BACKEND_configure_system_user_register_automatic_' ) . '"', 'trim' );

	$this->form_validation->set_rules ( '_user_locked_status_', '"' . tr ( '_BACKEND_configure_system_user_locked_status_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_user_locked_timeout_', '"' . tr ( '_BACKEND_configure_system_user_locked_timeout_' ) . '"', 'required|trim|numeric|max_length[2]|less_than[31]|greater_than[4]' );

	// Return Data
	$json = array(
	    'csrf' => array(
		$this->security->get_csrf_token_name () => $this->security->get_csrf_hash ()
	    )
	);

	// Check Validation
	if ( !$this->form_validation->run () )
	{
	    $json['status'] = FALSE;
	    $json['message'] = validation_errors ();
	    $json['rules'] = array(
		//'_user_login_max_attemps_' => form_error ( '_user_login_max_attemps_' ) ? 'has-error' : 'has-success',
		//'_user_login_captcha_' => form_error ( '_user_login_captcha_' ) ? 'has-error' : 'has-success',
		//'_user_register_enabled_' => form_error ( '_user_register_enabled_' ) ? 'has-error' : 'has-success',
		//'_user_register_automatic_' => form_error ( '_user_register_automatic_' ) ? 'has-error' : 'has-success'
		'_user_locked_status_' => form_error ( '_user_locked_status_' ) ? 'has-error' : 'has-success',
		'_user_locked_timeout_' => form_error ( '_user_locked_timeout_' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    // Load library
	    $this->load->model ( 'backend/system_settings_model' );

	    // Form Values
	    //$form['_user_login_max_attemps_'] = $this->input->post ( '_user_login_max_attemps_', TRUE );
	    //$form['_user_login_captcha_'] = $this->input->post ( '_user_login_captcha_', TRUE );
	    //$form['_user_register_enabled_'] = $this->input->post ( '_user_register_enabled_', TRUE );
	    //$form['_user_register_automatic_'] = $this->input->post ( '_user_register_automatic_', TRUE );

	    $form['_user_locked_status_'] = $this->input->post ( '_user_locked_status_', TRUE );
	    $form['_user_locked_timeout_'] = $this->input->post ( '_user_locked_timeout_', TRUE );

	    // Update config
	    if ( $this->system_settings_model->update ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_SUCCESS_update_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_ERROR_update_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    private function _system_seo_form ()
    {
	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( '_seo_title_', '"' . tr ( '_BACKEND_configure_system_seo_title_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_seo_keywords_', '"' . tr ( '_BACKEND_configure_system_seo_keywords_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_seo_description_', '"' . tr ( '_BACKEND_configure_system_seo_description_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_seo_google_analytics_', '"' . tr ( '_BACKEND_configure_system_seo_google_analytics_' ) . '"', 'trim' );

	// Return Data
	$json = array(
	    'csrf' => array(
		$this->security->get_csrf_token_name () => $this->security->get_csrf_hash ()
	    )
	);

	// Check Validation
	if ( !$this->form_validation->run () )
	{
	    $json['status'] = FALSE;
	    $json['message'] = validation_errors ();
	    $json['rules'] = array(
		'_seo_title_' => form_error ( '_seo_title_' ) ? 'has-error' : 'has-success',
		'_seo_keywords_' => form_error ( '_seo_keywords_' ) ? 'has-error' : 'has-success',
		'_seo_description_' => form_error ( '_seo_description_' ) ? 'has-error' : 'has-success',
		'_seo_google_analytics_' => form_error ( '_seo_google_analytics_' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    // Load library
	    $this->load->model ( 'backend/system_settings_model' );

	    // Form Values
	    $form['_seo_title_'] = $this->input->post ( '_seo_title_', TRUE );
	    $form['_seo_keywords_'] = $this->input->post ( '_seo_keywords_', TRUE );
	    $form['_seo_description_'] = $this->input->post ( '_seo_description_', TRUE );
	    $form['_seo_google_analytics_'] = $this->input->post ( '_seo_google_analytics_', TRUE );

	    // Check if user can login
	    if ( $this->system_settings_model->update ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_SUCCESS_update_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_ERROR_update_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    private function _system_theme_form ()
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	// $this->form_validation->set_rules ( '_system_theme_frontend_', '"' . tr ( '_BACKEND_configure_system_frontend_theme_' ) . '"', 'required|trim' );
	// $this->form_validation->set_rules ( '_system_theme_backend_', '"' . tr ( '_BACKEND_configure_system_backend_theme_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_system_theme_backend_style_', '"' . tr ( '_BACKEND_configure_system_backend_theme_style_' ) . '"', 'required|trim' );

	$this->form_validation->set_rules ( '_system_image_watermark_status_', '"' . tr ( '_BACKEND_configure_system_image_watermark_status_' ) . '"', 'required|trim' );

	// Validation Conditions
	if ( ( bool ) $this->input->post ( '_system_image_watermark_status_' ) === TRUE )
	{
	    $this->form_validation->set_rules ( '_system_image_watermark_position_', '"' . tr ( '_BACKEND_configure_system_image_watermark_position_' ) . '"', 'required|is_natural_no_zero' );
	    $this->form_validation->set_rules ( '_system_image_watermark_transparency_', '"' . tr ( '_BACKEND_configure_system_image_watermark_transparency_' ) . '"', 'required|numeric|max_length[3]' );
	}

	// Image Path
	$image_path = 'images/';

	// Form Error Content
	$this->form_validation->set_error_delimiters ( '', '<br>' );

	// Return Data
	$json = array(
	    'csrf' => array(
		$this->security->get_csrf_token_name () => $this->security->get_csrf_hash ()
	    )
	);

	// Check Validation
	if ( !$this->form_validation->run () )
	{
	    $json['status'] = FALSE;
	    $json['message'] = validation_errors ();
	    $json['rules'] = array(
		'_system_theme_frontend_' => form_error ( '_system_theme_frontend_' ) ? 'has-error' : 'has-success',
		'_system_theme_backend_' => form_error ( '_system_theme_backend_' ) ? 'has-error' : 'has-success',
		'_system_theme_backend_style_' => form_error ( '_system_theme_backend_style_' ) ? 'has-error' : 'has-success',
		'_system_image_watermark_status_' => form_error ( '_system_image_watermark_status_' ) ? 'has-error' : 'has-success',
		'_system_image_watermark_' => form_error ( '_system_image_watermark_' ) ? 'has-error' : 'has-success',
		'_system_image_watermark_position_' => form_error ( '_system_image_watermark_position_' ) ? 'has-error' : 'has-success',
		'_system_image_watermark_transparency_' => form_error ( '_system_image_watermark_transparency_' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    if ( $_FILES && isset ( $_FILES['_system_image_not_available_']['name'] ) )
	    {
		// Upload the file
		$config['upload_path'] = $this->template->path ( 'uploads', '', TRUE ) . '/' . $image_path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '500';
		$config['max_width'] = '141024';
		$config['max_height'] = '11768';
		$config['file_name'] = 'no_image';

		$this->load->library ( 'upload', $config );

		if ( !$this->upload->do_upload ( '_system_image_not_available_' ) )
		{
		    $json['status'] = FALSE;
		    $json['message'] = $this->upload->display_errors ();
		    $json['rules'] = array(
			'_system_image_not_available_' => 'has-error'
		    );
		    die ( json_encode ( $json ) );
		}
		else
		{

		    // Delete Previus avatar
		    $this->template->delete ( 'uploads', $this->settings_model->system['_system_image_not_available_'] );

		    // Image Info
		    $no_image = $this->upload->data ();
		}
	    }

	    if ( $_FILES && isset ( $_FILES['_system_image_watermark_']['name'] ) )
	    {
		// Upload the file
		$config['upload_path'] = $this->template->path ( 'uploads', '', TRUE ) . '/' . $image_path;
		$config['allowed_types'] = 'png';
		$config['max_size'] = '500';
		$config['max_width'] = '141024';
		$config['max_height'] = '11768';
		$config['file_name'] = 'watermark';

		$this->load->library ( 'upload', $config );

		if ( !$this->upload->do_upload ( '_system_image_watermark_' ) )
		{
		    $json['status'] = FALSE;
		    $json['message'] = $this->upload->display_errors ();
		    $json['rules'] = array(
			'_system_image_watermark_' => 'has-error'
		    );
		    die ( json_encode ( $json ) );
		}
		else
		{

		    // Delete Previus avatar
		    $this->template->delete ( 'uploads', $this->settings_model->system['_system_image_watermark_'] );

		    // Image Info
		    $watermak = $this->upload->data ();
		}
	    }

	    // Load library
	    $this->load->model ( 'backend/system_settings_model' );

	    // Form Values
	    // $form['_system_theme_frontend_'] = $this->input->post ( '_system_theme_frontend_', TRUE );
	    // $form['_system_theme_backend_'] = $this->input->post ( '_system_theme_backend_', TRUE );
	    $form['_system_theme_backend_style_'] = $this->input->post ( '_system_theme_backend_style_', TRUE );
	    $form['_system_image_not_available_'] = (isset ( $no_image ) ) ? $image_path . $no_image['file_name'] : $this->settings_model->system['_system_image_not_available_'];
	    $form['_system_image_watermark_status_'] = $this->input->post ( '_system_image_watermark_status_', TRUE );
	    $form['_system_image_watermark_'] = (isset ( $watermak ) ) ? $image_path . $watermak['file_name'] : $this->settings_model->system['_system_image_watermark_'];
	    $form['_system_image_watermark_position_'] = $this->input->post ( '_system_image_watermark_position_', TRUE );
	    $form['_system_image_watermark_transparency_'] = $this->input->post ( '_system_image_watermark_transparency_', TRUE );

	    // Check if user can login
	    if ( $this->system_settings_model->update ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_SUCCESS_update_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_ERROR_update_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    private function _system_mail_form ()
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( '_mail_from_email_', '"' . tr ( '_BACKEND_configure_system_mail_from_email_' ) . '"', 'required|valid_email|trim' );
	$this->form_validation->set_rules ( '_mail_from_name_', '"' . tr ( '_BACKEND_configure_system_mail_from_name_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_mail_mailtype_', '"' . tr ( '_BACKEND_configure_system_mail_mailtype_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( '_mail_protocol_', '"' . tr ( '_BACKEND_configure_system__mail_protocol_' ) . '"', 'required' );

	// Validation Conditions
	if ( $this->input->post ( '_mail_protocol_' ) == 'smtp' )
	{
	    $this->form_validation->set_rules ( '_mail_smtp_host_', '"' . tr ( '_BACKEND_configure_system_mail_smtp_host_' ) . '"', 'required' );
	    $this->form_validation->set_rules ( '_mail_smtp_pass_', '"' . tr ( '_BACKEND_configure_system_mail_smtp_pass_' ) . '"', 'required' );
	    $this->form_validation->set_rules ( '_mail_smtp_port_', '"' . tr ( '_BACKEND_configure_system_mail_smtp_port_' ) . '"', 'required' );
	    $this->form_validation->set_rules ( '_mail_smtp_user_', '"' . tr ( '_BACKEND_configure_system_mail_smtp_user_' ) . '"', 'required' );
	}


	// Form Error Content
	$this->form_validation->set_error_delimiters ( '', '<br>' );

	// Return Data
	$json = array(
	    'csrf' => array(
		$this->security->get_csrf_token_name () => $this->security->get_csrf_hash ()
	    )
	);

	// Check Validation
	if ( !$this->form_validation->run () )
	{
	    $json['status'] = FALSE;
	    $json['message'] = validation_errors ();
	    $json['rules'] = array(
		'_mail_from_email_' => form_error ( '_mail_from_email_' ) ? 'has-error' : 'has-success',
		'_mail_from_name_' => form_error ( '_mail_from_name_' ) ? 'has-error' : 'has-success',
		'_mail_mailtype_' => form_error ( '_mail_mailtype_' ) ? 'has-error' : 'has-success',
		'_mail_protocol_' => form_error ( '_mail_protocol_' ) ? 'has-error' : 'has-success',
		'_mail_smtp_host_' => form_error ( '_mail_smtp_host_' ) ? 'has-error' : 'has-success',
		'_mail_smtp_pass_' => form_error ( '_mail_smtp_pass_' ) ? 'has-error' : 'has-success',
		'_mail_smtp_port_' => form_error ( '_mail_smtp_port_' ) ? 'has-error' : 'has-success',
		'_mail_smtp_user_' => form_error ( '_mail_smtp_user_' ) ? 'has-error' : 'has-success',
	    );
	}
	else
	{

	    // Load library
	    $this->load->model ( 'backend/system_settings_model' );

	    // Form Values
	    $form['_mail_from_email_'] = $this->input->post ( '_mail_from_email_', TRUE );
	    $form['_mail_from_name_'] = $this->input->post ( '_mail_from_name_', TRUE );
	    $form['_mail_mailtype_'] = $this->input->post ( '_mail_mailtype_', TRUE );
	    $form['_mail_protocol_'] = $this->input->post ( '_mail_protocol_', TRUE );
	    $form['_mail_smtp_host_'] = $this->input->post ( '_mail_smtp_host_', TRUE );
	    $form['_mail_smtp_pass_'] = $this->input->post ( '_mail_smtp_pass_', TRUE );
	    $form['_mail_smtp_port_'] = $this->input->post ( '_mail_smtp_port_', TRUE );
	    $form['_mail_smtp_user_'] = $this->input->post ( '_mail_smtp_user_', TRUE );

	    // Check if user can login
	    if ( $this->system_settings_model->update ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_SUCCESS_update_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_SYSTEM_SETTINGS_ERROR_update_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

}
