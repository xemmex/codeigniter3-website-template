<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Emails extends Backend_Controller
{

    public function index ()
    {

	// Load Model
	$this->load->model ( 'backend/emails_model' );

	// Load Users
	$data['emails'] = $this->emails_model->emails_get ();
	$data['emails_types'] = $this->emails_model->emails_get_types ();

	$data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	$this->template
		->set ( 'views', 'emails/index' )
		->set ( 'data', $data )
		->render ();
    }

    public function template_edit ( $uID = NULL )
    {

	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	if ( $this->input->is_ajax_request () )
	{

	    if ( $this->input->post ( 'ajax_submit' ) )
	    {
		// Libreary
		$this->load->library ( 'form_validation' );

		// Validation Rules
		foreach ( get_languages ( TRUE ) as $language )
		{
		    $this->form_validation->set_rules ( 'templates[' . $language['uID'] . '][subject]', tr ( '_GLOBAL_subject_' ), 'required|max_length[255]|trim' );
		}

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

		    // Validation Rules
		    foreach ( get_languages ( TRUE ) as $language )
		    {
			$json['rules']['templates[' . $language['uID'] . '][subject]'] = form_error ( 'templates[' . $language['uID'] . '][subject]' ) ? 'has-error' : 'has-success';
		    }
		}
		else
		{
		    // Load library
		    $this->load->model ( 'backend/emails_model' );

		    // Form Values
		    $form['uID'] = $uID;
		    $form['subject'] = $this->input->post ( 'key', TRUE );
		    $form['templates'] = $this->input->post ( 'templates', FALSE );

		    if ( $this->emails_model->template_edit ( $form ) )
		    {
			$json['status'] = TRUE;
			$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_SUCCESS_edit_template_' );
		    }
		    else
		    {
			$json['status'] = FALSE;
			$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_ERROR_edit_template_' );
		    }
		}

		// Output
		$this->output
			->set_header ( 'Content-Type: application/json; charset=utf-8' )
			->set_content_type ( 'application/json' )
			->set_output ( json_encode ( $json ) );
	    }
	    else
	    {

		// Load Model
		$this->load->model ( 'backend/emails_model' );

		// Load Template
		$data['data'] = $this->emails_model->template_get ( $uID );

		// Load View
		$this->template->view ( 'emails/modal/_template_edit', $data );
	    }
	}
    }

    public function templates ( $uID = NULL )
    {
	// Load Model
	$this->load->model ( 'backend/emails_model' );

	if ( isset ( $uID ) || is_numeric ( $uID ) )
	{
	    // Load Users
	    $data['template'] = $this->emails_model->template_get ( $uID );
	    $this->template->view ( 'emails/modal/_template_view', $data );
	}
	else
	{

	    // Load Users
	    $data['emails_types'] = $this->emails_model->emails_get_types ();

	    $data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	    $this->template
		    ->set ( 'views', 'emails/templates' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    public function logs ( $uID = NULL )
    {
	// Load Model
	$this->load->model ( 'backend/emails_model' );

	if ( isset ( $uID ) || is_numeric ( $uID ) )
	{
	    // Load Users
	    $data['log'] = $this->emails_model->logs_get ( array( 'uID' => $uID ) );
	    $this->template->view ( 'emails/modal/_log_view', $data );
	}
	else
	{

	    // Load Users
	    $data['logs'] = $this->emails_model->logs_get ();

	    $data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	    $this->template
		    ->set ( 'views', 'emails/logs' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    public function emails_add ()
    {

	// Libreary
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'name', '"' . tr ( '_GLOBAL_name_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( 'email', '"' . tr ( '_GLOBAL_email_' ) . '"', 'required|valid_email|trim' );
	$this->form_validation->set_rules ( 'cco', '"' . tr ( '_GLOBAL_cco_field_' ) . '"', 'required|is_natural|trim' );
	$this->form_validation->set_rules ( 'status', '"' . tr ( '_GLOBAL_status_' ) . '"', 'required|is_natural|trim' );
	$this->form_validation->set_rules ( 'emails_types[]', '"' . tr ( '_GLOBAL_emails_types_' ) . '"', 'required|trim' );


	// Form Error Content
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
		'name' => form_error ( 'name' ) ? 'has-error' : 'has-success',
		'email' => form_error ( 'email' ) ? 'has-error' : 'has-success',
		'cco' => form_error ( 'cco' ) ? 'has-error' : 'has-success',
		'status' => form_error ( 'status' ) ? 'has-error' : 'has-success',
		'emails_types' => form_error ( 'emails_types' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{
	    // Load library
	    $this->load->model ( 'backend/emails_model' );

	    // Form Values
	    $form['name'] = $this->input->post ( 'name', TRUE );
	    $form['email'] = $this->input->post ( 'email', TRUE );
	    $form['cco'] = $this->input->post ( 'cco', TRUE );
	    $form['status'] = $this->input->post ( 'status', TRUE );
	    $form['emails_types'] = $this->input->post ( 'emails_types', TRUE );


	    if ( $this->emails_model->emails_exists ( $form['email'] ) )
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_EMAILS_ERROR_email_already_exists_' );
	    }
	    else
	    if ( $this->emails_model->emails_add ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['reload'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_EMAILS_SUCCESS_add_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_EMAILS_ERROR_add_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function emails_delete ( $uID = NULL )
    {
	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	// Load Model
	$this->load->model ( 'backend/emails_model' );


	if ( $this->emails_model->emails_delete ( array( 'uID' => $uID ) ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_PAGE_BACKEND_EMAILS_SUCCESS_delete_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_EMAILS_ERROR_delete_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function emails_get_types ()
    {

	// Load Model
	$this->load->model ( 'backend/emails_model' );

	$email_types = $this->emails_model->emails_get_types ();

	foreach ( $email_types as $type )
	{
	    $json[] = array(
		'value' => $type['id'],
		'text' => html_entity_decode ( $type['text'] )
	    );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

}
