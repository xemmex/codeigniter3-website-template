<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Languages extends Backend_Controller
{

    public function index ()
    {

	// Load Model
	$this->load->model ( 'backend/languages_model' );

	// Load Users
	$data['languages'] = $this->languages_model->languages_get ();

	$data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	$this->template
		->set ( 'views', 'languages/index' )
		->set ( 'data', $data )
		->render ();
    }

    public function language_add ()
    {
	// Libreary
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'code', '"' . tr ( '_GLOBAL_language_code_' ) . '"', 'required|exact_length[2]|alpha|trim' );
	$this->form_validation->set_rules ( 'text', '"' . tr ( '_GLOBAL_name_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( 'status', '"' . tr ( '_GLOBAL_status_' ) . '"', 'required|is_natural|trim' );
	$this->form_validation->set_rules ( 'translations', '"' . tr ( '_GLOBAL_copy_translation_' ) . '"', 'is_natural|trim' );


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
		'code' => form_error ( 'code' ) ? 'has-error' : 'has-success',
		'text' => form_error ( 'text' ) ? 'has-error' : 'has-success',
		'status' => form_error ( 'status' ) ? 'has-error' : 'has-success',
		'translations' => form_error ( 'translations' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{
	    // Load library
	    $this->load->model ( 'backend/languages_model' );

	    // Form Values
	    $form['code'] = $this->input->post ( 'code', TRUE );
	    $form['text'] = $this->input->post ( 'text', TRUE );
	    $form['status'] = $this->input->post ( 'status', TRUE );
	    $form['translations'] = $this->input->post ( 'translations', TRUE );


	    if ( $this->languages_model->language_exists ( $form['code'] ) )
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_ERROR_language_already_exist_' );
	    }
	    else
	    if ( $this->languages_model->language_add ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['reload'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_SUCCESS_add_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_ERROR_add_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function language_delete ( $uID = NULL )
    {
	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	// Load Model
	$this->load->model ( 'backend/languages_model' );

	if ( $this->languages_model->language_delete ( array( 'uID' => $uID ) ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_SUCCESS_delete_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_ERROR_delete_exist_language_translations_in_other_tables_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function translation_add ()
    {

	// Libreary
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'key', '"' . tr ( '_GLOBAL_translation_key_' ) . '"', 'required|max_length[255]|trim' );

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
		'key' => form_error ( 'key' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{
	    // Load library
	    $this->load->model ( 'backend/languages_model' );

	    // Form Values
	    $form['key'] = $this->input->post ( 'key', TRUE );
	    $form['translation'] = $this->input->post ( 'translation', FALSE );


	    if ( $this->languages_model->translation_exists ( $form['key'] ) )
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_ERROR_translation_already_exist_' );
	    }
	    else
	    if ( $this->languages_model->translation_add ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['redraw'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_SUCCESS_add_translation_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_ERROR_add_translation_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function translation_edit ( $uID = NULL )
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
		$this->form_validation->set_rules ( 'key', '"' . tr ( '_GLOBAL_translation_key_' ) . '"', 'required|max_length[255]|trim' );

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
			'key' => form_error ( 'key' ) ? 'has-error' : 'has-success'
		    );
		}
		else
		{
		    // Load library
		    $this->load->model ( 'backend/languages_model' );

		    // Form Values
		    $form['key'] = $this->input->post ( 'key', TRUE );
		    $form['translations'] = $this->input->post ( 'translations', FALSE );

		    if ( $this->languages_model->translation_edit ( $form ) )
		    {
			$json['status'] = TRUE;
			$json['redraw'] = TRUE;
			$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_SUCCESS_edit_translation_' );
		    }
		    else
		    {
			$json['status'] = FALSE;
			$json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_ERROR_edit_translation_' );
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

		// Load library
		$this->load->model ( 'backend/languages_model' );

		// Load Translation
		$data['data'] = $this->languages_model->translation_get ( $uID );

		// Load View
		$this->template->view ( 'languages/modal/_translation_edit', $data );
	    }
	}
    }

    public function translation_delete ( $uID = NULL )
    {
	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	// Load Model
	$this->load->model ( 'backend/languages_model' );

	if ( $this->languages_model->translation_delete ( array( 'uID' => $uID ), TRUE ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_TRANSLATIONS_SUCCESS_delete_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_LANGUAGES_TRANSLATIONS_ERROR_delete_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function translations ( $uID = NULL )
    {

	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	if ( $this->input->is_ajax_request () )
	{
	    // Load model
	    $this->load->model ( 'backend/languages_model' );

	    // Data from model
	    $json = $this->languages_model->translations_get ( array( 'uID' => $uID ), TRUE, TRUE );

	    // Output
	    $this->output
		    ->set_header ( 'Content-Type: application/json; charset=utf-8' )
		    ->set_content_type ( 'application/json' )
		    ->set_output ( $json );
	}
	else
	{

	    // Load Users
	    $data['language'] = $uID;

	    $data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	    $this->template
		    ->set ( 'views', 'languages/translations' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

}
