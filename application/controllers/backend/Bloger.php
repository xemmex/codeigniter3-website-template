<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Bloger extends Auth_Controller
{

    public function __construct ()
    {
	// Parent __construct
	parent::__construct ();

	// Load Settings
	$this->settings_model->load ( 'blog' );

	// Load Model
	$this->load->model ( 'backend/bloger_model' );

	// Load Helper
	$this->load->helper ( 'text' );
	$this->load->helper ( 'pagination' );
    }

    public function categories ()
    {

	$data['categories'] = $this->bloger_model->categories_get_all ();

	$data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_CATEGORIES_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_CATEGORIES_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_CATEGORIES_title_' );

	$this->template
		->set ( 'views', 'bloger/categories' )
		->set ( 'data', $data )
		->render ();
    }

    public function category_delete ( $uID = NULL )
    {

	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	if ( $this->bloger_model->category_in_use ( $uID ) )
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_BLOG_ERROR_category_in_use_' );
	}
	else
	if ( $this->bloger_model->category_delete ( $uID ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_PAGE_BACKEND_BLOG_SUCCESS_delete_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_BLOG_ERROR_delete_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function category_add ()
    {

	// Libreary
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'name', '"' . tr ( '_GLOBAL_name_' ) . '"', 'required|max_length[255]|trim' );

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
		'name' => form_error ( 'name' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    // Form Values
	    $form['name'] = $this->input->post ( 'name', TRUE );
	    $form['translation'] = $this->input->post ( 'translation', TRUE );


	    if ( $this->bloger_model->category_exists ( $form['name'] ) )
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_BLOG_ERROR_category_already_exist_' );
	    }
	    else
	    if ( $this->bloger_model->category_add ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_BLOG_SUCCESS_add_category_' );
		$json['reload'] = TRUE;
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_BLOG_ERROR_add_category_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function category_edit ( $uID = NULL )
    {

	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	if ( $this->input->is_ajax_request () )
	{
	    self::_category_edit_form ( $uID );
	}
	else
	{

	    // Load Users
	    $data = $this->bloger_model->category_get ( $uID );

	    $data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	    $this->template
		    ->set ( 'views', 'bloger/category_edit' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    private function _category_edit_form ( $uID )
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'name', '"' . tr ( '_GLOBAL_name_' ) . '"', 'required|trim' );

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
		'name' => form_error ( 'name' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    // Form Values
	    $form['name'] = $this->input->post ( 'name', TRUE );
	    $form['translation'] = $this->input->post ( 'translation', TRUE );

	    // Check if user can login
	    if ( $this->bloger_model->category_edit ( $form, $uID ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_CATEGORY_SUCCESS_edit_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_CATEGORY_ERROR_edit_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function index ( $start = 0 )
    {
	self::entries ( $start );
    }

    public function entries ( $start = 0 )
    {

	// Get Blog Data
	$data['total'] = $this->bloger_model->entries_get ( NULL, TRUE );
	$data['entries'] = $this->bloger_model->entries_get ( array( 'limit' => $this->settings_model->blog['items_per_page'], 'start' => $start ) );
	$data['categories'] = $this->bloger_model->categories_get ();
	$data['archive'] = $this->bloger_model->archive_get ();
	$data['pagination'] = pagination ( backend_url ( array( 'bloger', 'index' ) ), $data['total'], $this->settings_model->blog['items_per_page'], 5 );

	$data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	$this->template
		->set ( 'views', 'bloger/entries' )
		->set ( 'data', $data )
		->render ();
    }

    public function entries_search ( $query = '', $start = 0 )
    {

	// Get Blog Data
	$data['query'] = ( isset ( $query ) && !empty ( $query ) ) ? urldecode ( $query ) : urldecode ( $this->input->post ( 'query' ) );

	$data['total'] = $this->bloger_model->entries_get ( array( 'search' => $data['query'] ), TRUE );
	$data['entries'] = $this->bloger_model->entries_get ( array( 'search' => $data['query'], 'limit' => $this->settings_model->blog['items_per_page'], 'start' => $start ) );
	$data['categories'] = $this->bloger_model->categories_get ();
	$data['archive'] = $this->bloger_model->archive_get ();
	$data['pagination'] = pagination ( backend_url ( array( 'bloger', 'entries-search', $data['query'] ) ), $data['total'], $this->settings_model->blog['items_per_page'], 6 );

	// Seo Data
	$data['seo_description'] = tr ( '_SEO_PAGE_BLOG_SEARCH_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BLOG_SEARCH_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BLOG_SEARCH_title_' ) . ' : ' . $data['query'];

	// Render Template
	$this->template
		->set ( 'views', 'bloger/entries_search' )
		->set ( 'data', $data )
		->render ();
    }

    public function entries_category ( $category, $start = 0 )
    {

	// Get Blog Data
	$data['category'] = urldecode ( $category );
	$data['total'] = $this->bloger_model->entries_get ( array( 'category' => $data['category'] ), TRUE );
	$data['entries'] = $this->bloger_model->entries_get ( array( 'category' => $data['category'], 'limit' => $this->settings_model->blog['items_per_page'], 'start' => $start ) );
	$data['categories'] = $this->bloger_model->categories_get ();
	$data['archive'] = $this->bloger_model->archive_get ();
	$data['pagination'] = pagination ( backend_url ( array( 'bloger', 'entries-category', $data['category'] ) ), $data['total'], $this->settings_model->blog['items_per_page'], 6 );

	// Seo Data
	$data['seo_description'] = tr ( '_SEO_PAGE_BLOG_CATEGORY_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BLOG_CATEGORY_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BLOG_CATEGORY_title_' ) . ' : ' . $data['category'];

	// Render Template
	$this->template
		->set ( 'views', 'bloger/entries_category' )
		->set ( 'data', $data )
		->render ();
    }

    public function entries_archive ( $year, $month, $start = 0 )
    {

	// Get Blog Data
	$data['year'] = urldecode ( $year );
	$data['month'] = urldecode ( $month );
	$data['total'] = $this->bloger_model->entries_get ( array( 'year' => $data['year'], 'month' => $data['month'] ), TRUE );
	$data['entries'] = $this->bloger_model->entries_get ( array( 'year' => $data['year'], 'month' => $data['month'], 'limit' => $this->settings_model->blog['items_per_page'], 'start' => $start ) );
	$data['categories'] = $this->bloger_model->categories_get ();
	$data['archive'] = $this->bloger_model->archive_get ();
	$data['pagination'] = pagination ( backend_url ( array( 'bloger', 'entries-archive', $data['year'], $data['month'] ) ), $data['total'], $this->settings_model->blog['items_per_page'], 7 );

	// Seo Data
	$data['seo_description'] = tr ( '_SEO_PAGE_BLOG_ARCHIVE_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BLOG_ARCHIVE_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BLOG_ARCHIVE_title_' ) . ' : ' . $data['year'] . '/' . $data['month'];

	// Render Template
	$this->template
		->set ( 'views', 'bloger/entries_archive' )
		->set ( 'data', $data )
		->render ();
    }

    public function entry_add ()
    {
	if ( $this->input->is_ajax_request () )
	{
	    self::_entry_add_form ();
	}
	else
	{

	    $data['categories'] = $this->bloger_model->categories_get_all ();

	    $data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	    $this->template
		    ->set ( 'plugins', 'js', array( 'ckeditor/ckeditor' => '20140819' ) )
		    ->set ( 'plugins', 'js', array( 'ckeditor/adapters/jquery' => '20140808' ) )
		    ->set ( 'views', 'bloger/entry_add' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    private function _entry_add_form ()
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'status_id', '"' . tr ( '_GLOBAL_status_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( 'category_id', '"' . tr ( '_GLOBAL_category_' ) . '"', 'required|trim' );

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
		'status_id' => form_error ( 'status_id' ) ? 'has-error' : 'has-success',
		'category_id' => form_error ( 'category_id' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{

	    if ( $_FILES && isset ( $_FILES['image']['name'] ) )
	    {
		$upload_folder = 'blog/';

		// Upload the file
		$config['upload_path'] = $this->template->path ( 'uploads', '', TRUE ) . '/' . $upload_folder;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '500';
		$config['max_width'] = '141024';
		$config['max_height'] = '11768';

		$this->load->library ( 'upload', $config );

		if ( !$this->upload->do_upload ( 'image' ) )
		{
		    $json['status'] = FALSE;
		    $json['message'] = $this->upload->display_errors ();
		    $json['rules'] = array(
			'image' => 'has-error'
		    );

		    die ( json_encode ( $json ) );
		}
		else
		{
		    // Image Info
		    $image = $this->upload->data ();
		}
	    }

	    // Form Values
	    $form['status_id'] = $this->input->post ( 'status_id', TRUE );
	    $form['category_id'] = $this->input->post ( 'category_id', TRUE );
	    $form['image'] = (isset ( $image )) ? $upload_folder . $image['file_name'] : '';
	    $form['translations'] = $this->input->post ( 'translations', FALSE );

	    // Check if user can login
	    if ( $this->bloger_model->entry_add ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_BLOG_SUCCESS_add_' );
		$json['redirect'] = backend_url ( array( 'bloger' ) );
	    }
	    else
	    {
		$json['status'] = FALSE;

		$json['message'] = tr ( '_PAGE_BACKEND_BLOG_ERROR_add_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function entry_edit ( $uID = NULL )
    {

	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	if ( $this->input->is_ajax_request () )
	{
	    self::_entry_edit_form ( $uID );
	}
	else
	{
	    // Load Users
	    $data = $this->bloger_model->entry_get ( $uID );

	    $data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_SYSTEM_title_' );

	    $this->template
		    ->set ( 'plugins', 'js', array( 'ckeditor/ckeditor' => '20140819' ) )
		    ->set ( 'plugins', 'js', array( 'ckeditor/adapters/jquery' => '20140808' ) )
		    ->set ( 'views', 'bloger/entry_edit' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    private function _entry_edit_form ( $uID )
    {

	if ( $_FILES && isset ( $_FILES['image']['name'] ) )
	{
	    $upload_folder = 'blog/';

	    // Upload the file
	    $config['upload_path'] = $this->template->path ( 'uploads', '', TRUE ) . '/' . $upload_folder;
	    $config['allowed_types'] = 'gif|jpg|jpeg|png';
	    $config['max_size'] = '500';
	    $config['max_width'] = '141024';
	    $config['max_height'] = '11768';

	    $this->load->library ( 'upload', $config );

	    if ( !$this->upload->do_upload ( 'image' ) )
	    {
		$json['status'] = FALSE;
		$json['message'] = $this->upload->display_errors ();
		$json['rules'] = array(
		    'image' => 'has-error'
		);
	    }
	    else
	    {

		// Image Info
		$image = $this->upload->data ();

		// Change Data in DB
		$this->bloger_model->entry_change_image ( $uID, $upload_folder . $image['file_name'] );
	    }
	}

	// Form Values
	$form['translations'] = $this->input->post ( 'translations', FALSE );

	// Check if user can login
	if ( $this->bloger_model->entry_edit ( $form, $uID ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_PAGE_BACKEND_BLOG_SUCCESS_edit_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_BLOG_ERROR_edit_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function entry_delete ( $uID = NULL )
    {

	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	if ( $this->bloger_model->entry_delete ( $uID ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_PAGE_BACKEND_BLOG_SUCCESS_delete_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_BLOG_ERROR_delete_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function categories_get ()
    {

	$categories = $this->bloger_model->categories_get_all ();

	foreach ( $categories as $category )
	{
	    $json[] = array(
		'value' => $category['id'],
		'text' => html_entity_decode ( $category['text'] )
	    );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

}
