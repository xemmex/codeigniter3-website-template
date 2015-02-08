<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Auth extends Auth_Controller
{

    public function index ()
    {
	self::login ();
    }

    public function login ()
    {
	// Check User Login
	if ( is_logged_in () )
	{
	    $this->session->set_flashdata ( 'redirect', uri_string () );

	    redirect ( 'backend' );
	}

	// Login request
	if ( $this->input->is_ajax_request () )
	{
	    self::_login_ajax ();
	}
	else
	{
	    self::_login_form ();
	}
    }

    private function _login_ajax ()
    {

	// Libreary
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'email', '"' . tr ( '_GLOBAL_email_' ) . '"', 'required|valid_email|trim' );
	$this->form_validation->set_rules ( 'password', '"' . tr ( '_GLOBAL_password_' ) . '"', 'required|trim' );

	// Form Error Content
	// Form Error Content
	$this->form_validation->set_error_delimiters ( '<p>', '</p>' );

	// Return Data
	$json = array(
	    'csrf' => array(
		$this->security->get_csrf_token_name () => $this->security->get_csrf_hash ()
	    )
	);

	// Check Validation
	if ( is_logged_in () )
	{
	    $json['status'] = TRUE;
	    $json['redirect'] = backend_url ();
	}
	else
	if ( !$this->form_validation->run () )
	{
	    $json['status'] = FALSE;
	    $json['message'] = validation_errors ();
	    $json['rules'] = array(
		'name' => form_error ( 'name' ) ? 'has-error' : 'has-success',
		'email' => form_error ( 'email' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    // Form Values
	    $form['email'] = $this->input->post ( 'email', TRUE );
	    $form['password'] = $this->input->post ( 'password', TRUE );
	    $form['remember'] = $this->input->post ( 'remember', TRUE );

	    // Load library
	    $this->load->model ( 'auth_model' );

	    // Check if user can login
	    if ( $this->auth_model->login ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['redirect'] = backend_url ();
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = $this->auth_model->error;
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    private function _login_form ()
    {
	if ( is_logged_in () )
	{
	    backend_url ();
	}

	// Libreary
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'email', '"' . tr ( '_GLOBAL_email_' ) . '"', 'required|valid_email|trim' );
	$this->form_validation->set_rules ( 'password', '"' . tr ( '_GLOBAL_password_' ) . '"', 'required|trim' );

	// Error Class
	$data['form_class'] = '';
	$data['form_error_class']['email'] = '';
	$data['form_error_class']['password'] = '';

	// Redirect
	$this->session->keep_flashdata ( 'redirect' );

	// Auth Login Form
	if ( $this->input->post ( 'email' ) || $this->input->post ( 'password' ) )
	{

	    // Check Validation
	    if ( !$this->form_validation->run () )
	    {
		// Message Data
		$data['form_class'] = 'danger';
		$data['form_error'] = validation_errors ();
		$data['form_error_class']['email'] = form_error ( 'email' ) ? 'has-error' : 'has-success';
		$data['form_error_class']['password'] = form_error ( 'password' ) ? 'has-error' : 'has-success';
	    }
	    else
	    {

		// Form Values
		$form['email'] = $this->input->post ( 'email', TRUE );
		$form['password'] = $this->input->post ( 'password', TRUE );
		$form['remember'] = $this->input->post ( 'remember', TRUE );

		// Load library
		$this->load->model ( 'auth_model' );

		// Check if user can login
		if ( $this->auth_model->login ( $form ) )
		{
		    $redirect = $this->session->flashdata ( 'redirect' );

		    if ( isset ( $redirect ) )
		    {
			redirect ( $redirect, 'refresh' );
		    }
		    else
		    {
			redirect ( 'backend' );
		    }
		}
		else
		{
		    // Message Data
		    $data['form_class'] = 'danger';
		    $data['form_error'] = $this->auth_model->error;
		}
	    }
	}

	// Seo Data
	$data['seo_description'] = tr ( '_SEO_PAGE_LOGIN_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_AUTH_LOGIN_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_AUTH_LOGIN_title_' );

	// Render Template
	$this->template
		->set ( 'template', 'login' )
		->set ( 'views', 'auth/login' )
		->set ( 'data', $data )
		->render ();
    }

    public function locked ()
    {

	// Check user login
	if ( !is_logged_in () )
	{
	    redirect ( 'auth/login' );
	}

	// Libreary
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'password', '"' . tr ( '_GLOBAL_password_' ) . '"', 'required|trim' );

	// Error Class
	$data['form_class'] = '';
	$data['form_error_class']['password'] = '';

	// Auth Login Form
	if ( $this->input->post ( 'password' ) )
	{

	    // Check Validation
	    if ( !$this->form_validation->run () )
	    {
		// Message Data
		$data['form_class'] = 'danger';
		$data['form_error'] = validation_errors ();
		$data['form_error_class']['password'] = form_error ( 'password' ) ? 'has-error' : 'has-success';
	    }
	    else
	    {

		// Form Values
		$form['password'] = $this->input->post ( 'password', TRUE );

		// Load library
		$this->load->model ( 'auth_model' );

		// Check if user can login
		if ( $this->auth_model->login_from_locked ( $form ) )
		{
		    $redirect = $this->session->flashdata ( 'redirect' );

		    if ( isset ( $redirect ) && !empty ( $redirect ) )
		    {
			redirect ( $redirect, 'refresh' );
		    }
		    else
		    {
			redirect ( 'backend' );
		    }
		}
		else
		{
		    // Message Data
		    $data['form_class'] = 'danger';
		    $data['form_error'] = $this->auth_model->error;
		}
	    }
	}


	// Seo Data
	$data['seo_description'] = tr ( '_SEO_PAGE_LOCKED_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_AUTH_LOCKED_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_AUTH_LOCKED_title_' );

	// Render Template
	$this->template
		->set ( 'template', 'locked' )
		->set ( 'views', 'auth/locked' )
		->set ( 'data', $data )
		->render ();
    }

    public function register ( $token = '' )
    {
	if ( ( bool ) $this->settings_model->system['_user_register_enabled_'] === FALSE )
	{
	    show_404 ();
	}

	if ( is_logged_in () )
	{
	    redirect ( 'backend' );
	}

	if ( isset ( $token ) && !empty ( $token ) )
	{
	    self::_register_token ( $token );
	}
	else
	{

	    // Libreary
	    $this->load->library ( 'form_validation' );

	    // Validation Rules
	    $this->form_validation->set_rules ( 'name', '"' . tr ( '_GLOBAL_name_' ) . '"', 'required|trim' );
	    $this->form_validation->set_rules ( 'lastname', '"' . tr ( '_GLOBAL_lastname_' ) . '"', 'required|trim' );
	    $this->form_validation->set_rules ( 'email', '"' . tr ( '_GLOBAL_email_' ) . '"', 'required|valid_email|trim' );
	    $this->form_validation->set_rules ( 'email_repeat', '"' . tr ( '_GLOBAL_email_repeat_' ) . '"', 'required|valid_email|matches[email]|trim' );
	    $this->form_validation->set_rules ( 'password', '"' . tr ( '_GLOBAL_password_' ) . '"', 'required|trim|min_length[6]|password_check[1,1,1]' );
	    $this->form_validation->set_rules ( 'password_repeat', '"' . tr ( '_GLOBAL_password_repeat_' ) . '"', 'required|matches[password]|trim' );

	    // Form Error Content
	    $this->form_validation->set_error_delimiters ( '<p>', '</p>' );

	    // Errors Class
	    $data['form_class'] = '';
	    $data['form_error_class']['name'] = '';
	    $data['form_error_class']['lastname'] = '';
	    $data['form_error_class']['email'] = '';
	    $data['form_error_class']['email_repeat'] = '';
	    $data['form_error_class']['password'] = '';
	    $data['form_error_class']['password_repeat'] = '';

	    // Auth Register Form
	    if ( $this->input->post ( 'email' ) && $this->input->post ( 'password' ) )
	    {
		// Check Validation

		if ( !$this->form_validation->run () )
		{
		    // Message Data
		    $data['form_class'] = 'danger';
		    $data['form_error'] = validation_errors ();
		    $data['form_error_class']['name'] = form_error ( 'name' ) ? 'has-error' : 'has-success';
		    $data['form_error_class']['lastname'] = form_error ( 'lastname' ) ? 'has-error' : 'has-success';
		    $data['form_error_class']['email'] = form_error ( 'email' ) ? 'has-error' : 'has-success';
		    $data['form_error_class']['email_repeat'] = form_error ( 'email_repeat' ) ? 'has-error' : 'has-success';
		    $data['form_error_class']['password'] = form_error ( 'password' ) ? 'has-error' : 'has-success';
		    $data['form_error_class']['password_repeat'] = form_error ( 'password_repeat' ) ? 'has-error' : 'has-success';
		}
		else
		{

		    // Load library
		    $this->load->model ( 'auth_model' );

		    // Form Values
		    $form['name'] = $this->input->post ( 'name', TRUE );
		    $form['lastname'] = $this->input->post ( 'lastname', TRUE );
		    $form['email'] = $this->input->post ( 'email', TRUE );
		    $form['email_repeat'] = $this->input->post ( 'email_repeat', TRUE );
		    $form['password'] = $this->input->post ( 'password', TRUE );
		    $form['password_repeat'] = $this->input->post ( 'password_repeat', TRUE );
		    $form['register_token'] = $this->auth_model->register ( 1, $form );
		    $form['register_link'] = anchor ( 'auth/register/' . $form['register_token'], tr ( '_PAGE_AUTH_REGISTER_ACTIVATION_link_' ) );

		    // Register a User Profile
		    if ( isset ( $form['register_token'] ) && !empty ( $form['register_token'] ) && $form['register_token'] !== FALSE )
		    {

			// Load E-mail Model
			$this->load->model ( 'mailer_model' );

			if ( $this->mailer_model->send ( 3, $form, array( 'email' => $form['email'] ) ) )
			{

			    // SUCCESS
			    $data['form_class'] = 'success';
			    $data['form_error'] = tr ( '_PAGE_AUTH_REGISTER_SENDMAIL_SUCCESS_message_' );
			}
			else
			{
			    // ERROR
			    $data['form_class'] = 'danger';
			    $data['form_error'] = tr ( '_PAGE_AUTH_REGISTER_SENDMAIL_ERROR_message_' );
			}
		    }
		    else
		    {
			// Message Data
			$data['form_class'] = 'danger';
			$data['form_error'] = $this->auth_model->error;
		    }
		}
	    }

	    // Seo Data
	    $data['seo_description'] = tr ( '_SEO_PAGE_AUTH_REGISTER_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_AUTH_REGISTER_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_AUTH_REGISTER_title_' );

	    // Render Template
	    $this->template
		    ->set ( 'views', 'auth/register' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    private function _register_token ( $token )
    {

	if ( ( bool ) $this->settings_model->system['_user_register_automatic_'] === TRUE )
	{
	    // Load library
	    $this->load->model ( 'auth_model' );

	    $this->auth_model->is_register_token_valid ( $token );

	    if ( $this->auth_model->is_register_token_valid ( $token ) && $this->auth_model->activate_account ( $token ) )
	    {
		self::_register_token_message ( tr ( '_PAGE_AUTH_REGISTER_ACTIVATED_SUCCESS_message_' ), 'success' );
	    }
	    else
	    {
		self::_register_token_message ( $this->auth_model->error, 'danger' );
	    }
	}
	else
	{
	    self::_register_token_message ( tr ( '_PAGE_AUTH_REGISTER_ACTIVATED_PENDING_message_' ), 'info' );
	}
    }

    private function _register_token_message ( $message = '', $class = 'danger' )
    {
	// Data
	$data['register_message'] = $message;
	$data['register_class'] = $class;

	// Render Template
	$this->template
		->set ( 'views', 'auth/register_message' )
		->set ( 'data', $data )
		->render ();
    }

    public function forgot ( $token = '' )
    {

	if ( isset ( $token ) && !empty ( $token ) )
	{
	    self::_forgot_token ( $token );
	}
	else
	{

	    // Load Library
	    $this->load->library ( 'form_validation' );

	    // Validation Rules
	    $this->form_validation->set_rules ( 'email', '"' . tr ( '_GLOBAL_email_' ) . '"', 'required|valid_email|trim' );
	    $this->form_validation->set_rules ( 'email_repeat', '"' . tr ( '_GLOBAL_email_repeat_' ) . '"', 'required|valid_email|matches[email]|trim' );

	    // Form Error Content
	    $this->form_validation->set_error_delimiters ( '<p>', '</p>' );

	    // Error Class
	    $data['form_class'] = '';
	    $data['form_error_class']['email'] = form_error ( 'email' ) ? 'has-error' : '';
	    $data['form_error_class']['email_repeat'] = form_error ( 'email_repeat' ) ? 'has-error' : '';


	    // Auth Register Form
	    if ( $this->input->post ( 'email' ) && $this->input->post ( 'email_repeat' ) )
	    {

		// Check Validation
		if ( !$this->form_validation->run () )
		{
		    // Message Data
		    $data['form_class'] = 'danger';
		    $data['form_error'] = validation_errors ();
		    $data['form_error_class']['email'] = form_error ( 'email' ) ? 'has-error' : 'has-success';
		    $data['form_error_class']['email_repeat'] = form_error ( 'email_repeat' ) ? 'has-error' : 'has-success';
		}
		else
		{

		    // Load library
		    $this->load->model ( 'auth_model' );

		    // Form Values
		    $form['email'] = $this->input->post ( 'email', TRUE );
		    $form['email_repeat'] = $this->input->post ( 'email_repeat', TRUE );
		    $form['forgot_token'] = $this->auth_model->create_forgot_token ( $form['email'], $form['email_repeat'] );
		    $form['forgot_link'] = anchor ( 'auth/forgot/' . $form['forgot_token'], tr ( '_PAGE_AUTH_FORGOT_ACTIVATION_link_' ) );

		    // Check if user can login
		    if ( isset ( $form['forgot_token'] ) && !empty ( $form['forgot_token'] ) && $form['forgot_token'] !== FALSE )
		    {
			// Load E-mail Model
			$this->load->model ( 'mailer_model' );

			if ( $this->mailer_model->send ( 2, $form, array( 'email' => $form['email'] ) ) )
			{

			    // SUCCESS
			    $data['form_class'] = 'success';
			    $data['form_error'] = tr ( '_PAGE_AUTH_FORGOT_SENDMAIL_SUCCESS_message_' );
			}
			else
			{
			    // ERROR
			    $data['form_class'] = 'danger';
			    $data['form_error'] = tr ( '_PAGE_AUTH_FORGOT_SENDMAIL_ERROR_message_' );
			}
		    }
		    else
		    {
			// Message Data
			$data['form_class'] = 'danger';
			$data['form_error'] = $this->auth_model->error;
		    }
		}
	    }

	    // Seo Data
	    $data['seo_description'] = tr ( '_SEO_PAGE_AUTH_FORGOT_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_AUTH_FORGOT_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_AUTH_FORGOT_title_' );

	    // Render Template
	    $this->template
		    ->set ( 'views', 'auth/forgot' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    private function _forgot_token ( $token )
    {
	// Load library
	$this->load->model ( 'auth_model' );

	if ( $this->auth_model->is_forgot_token_valid ( $token ) )
	{
	    self::_forgot_token_success ( $token );
	}
	else
	{
	    self::_forgot_token_message ( $this->auth_model->error );
	}
    }

    private function _forgot_token_success ( $token )
    {

	// Load Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'password', '"' . tr ( '_GLOBAL_password_' ) . '"', 'required|trim|min_length[6]|password_check[1,1,1]' );
	$this->form_validation->set_rules ( 'password_repeat', '"' . tr ( '_GLOBAL_password_repeat_' ) . '"', 'required|matches[password]|trim' );

	// Form Error Content
	$this->form_validation->set_error_delimiters ( '<p>', '</p>' );

	// Error Class
	$data['form_class'] = '';
	$data['form_error_class']['password'] = '';
	$data['form_error_class']['password_repeat'] = '';

	// Auth Forgot Password Form
	if ( $this->input->post ( 'password' ) && $this->input->post ( 'password_repeat' ) )
	{

	    // Check Validation
	    if ( !$this->form_validation->run () )
	    {
		// Message Data
		$data['form_class'] = 'danger';
		$data['form_error'] = validation_errors ();
		$data['form_error_class']['password'] = form_error ( 'password' ) ? 'has-error' : 'has-success';
		$data['form_error_class']['password_repeat'] = form_error ( 'password_repeat' ) ? 'has-error' : 'has-success';

		// Render Template
		$this->template
			->set ( 'views', 'auth/forgot_token_form' )
			->set ( 'data', $data )
			->render ();
	    }
	    else
	    {

		// Form Values
		$form['password'] = $this->input->post ( 'password', TRUE );
		$form['password_repeat'] = $this->input->post ( 'password_repeat', TRUE );

		// Check if user can login
		if ( $this->auth_model->change_password_from_token ( $token, $form['password'] ) )
		{
		    self::_forgot_token_message ( tr ( '_PAGE_AUTH_FORGOT_PASSWORD_CHANGE_SUCCESS_message_' ), 'success' );
		}
		else
		{
		    self::_forgot_token_message ( tr ( '_PAGE_AUTH_FORGOT_PASSWORD_CHANGE_ERROR_message_' ), 'danger' );
		}
	    }
	}
	else
	{
	    // Render Template
	    $this->template
		    ->set ( 'views', 'auth/forgot_token_form' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    private function _forgot_token_message ( $message = '', $class = 'danger' )
    {
	// Data
	$data['forgot_token_message'] = $message;
	$data['forgot_token_class'] = $class;

	// Render Template
	$this->template
		->set ( 'views', 'auth/forgot_token_message' )
		->set ( 'data', $data )
		->render ();
    }

    public function logout ( $ajax = FALSE )
    {

	delete_cookie ( "remember_id" );
	delete_cookie ( "remember_token" );

	$this->session->set_userdata ( array( 'is_logged_in' => FALSE ) );

	session_destroy ();

	if ( !$ajax )
	{
	    redirect ( 'auth/login' );
	}
    }

}
