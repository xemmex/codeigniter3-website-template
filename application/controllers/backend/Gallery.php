<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Gallery extends Backend_Controller
{

    public function index ()
    {

	$this->load->model ( 'backend/gallery_model' );

	$data['gallery'] = $this->gallery_model->gallery_get ();
	$data['categories'] = $this->gallery_model->categories_get ();

	$data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_GALLERY_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_GALLERY_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_GALLERY_title_' );

	$this->template
		->set ( 'plugins', 'css', 'fupload/css/jquery.fileupload' )
		->set ( 'plugins', 'js', 'imagesloaded/js/imagesloaded.pkgd.min' )
		->set ( 'plugins', 'js', 'shuffle/js/jquery.shuffle.modernizr.min' )
		->set ( 'plugins', 'js', 'fupload/js/jquery.ui.widget' )
		->set ( 'plugins', 'js', 'fupload/js/jquery.iframe-transport' )
		->set ( 'plugins', 'js', 'fupload/js/jquery.fileupload' )
		->set ( 'plugins', 'js', 'fupload/js/jquery.fileupload-process' )
		->set ( 'plugins', 'js', 'fupload/js/jquery.fileupload-validate' )
		->set ( 'js', 'gallery/index' )
		->set ( 'views', 'gallery/index' )
		->set ( 'data', $data )
		->render ();
    }

    public function categories ()
    {

	$this->load->model ( 'backend/gallery_model' );

	$data['categories'] = $this->gallery_model->categories_get ();

	$data['seo_description'] = tr ( '_SEO_PAGE_BACKEND_CATEGORIES_description_' );
	$data['seo_keywords'] = tr ( '_SEO_PAGE_BACKEND_CATEGORIES_keywords_' );
	$data['seo_title'] = tr ( '_SEO_PAGE_BACKEND_CATEGORIES_title_' );

	$this->template
		->set ( 'views', 'gallery/categories' )
		->set ( 'data', $data )
		->render ();
    }

    public function image_add ()
    {
	if ( !$this->input->is_ajax_request () )
	{
	    show_404 ();
	}

	// File Name
	$file_name = 'image';

	// Image path
	$image_path = 'images/gallery/';

	// Upload the file
	$config['upload_path'] = $this->template->path ( 'uploads', '', TRUE ) . '/' . $image_path;
	$config['allowed_types'] = 'gif|jpg|jpeg|png';
	$config['max_size'] = 5000;
	$config['encrypt_name'] = TRUE;

	// Load Upload library
	$this->load->library ( 'upload', $config );

	// Check if upload has errors
	if ( !$this->upload->do_upload ( $file_name ) )
	{

	    $json['status'] = FALSE;
	    $json['message'] = $this->upload->display_errors ( '', '' );
	}
	else
	{
	    // Get Upload Data
	    $image = $this->upload->data ();
	    $image['db_name'] = $image_path . $image['file_name'];

	    // Load Gallery model
	    $this->load->model ( 'backend/gallery_model' );

	    // Save image info to DB
	    if ( $this->gallery_model->image_add ( $image ) )
	    {

		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_BACKEND_GALLERY_SUCCESS_saving_image_to_db_' );
		$json['image'] = '
		    <div class="item col-lg-2 col-md-2 col-xs-6" data-categories="0" id="element-' . $this->gallery_model->image['id'] . '">
			<div class="thumbnail">
			    <div class="caption">
				<div class="btn-container">
				    <button
					class="btn btn-sm btn-warning dialog-preview"
					data-img-url="' . $this->template->path ( 'uploads', $this->gallery_model->image['url'] ) . '"
					data-title="' . tr ( '_GLOBAL_preview_' ) . '"
					data-size="large"
					>
					<i class="glyphicon glyphicon-eye-open"></i>
				    </button>
				    <button
					class="btn btn-sm btn-success change-status"
					data-url="' . backend_url ( array( 'helper', 'change-status' ) ) . '"
					data-table="galeria_images"
					data-column="uID_estados"
					data-value="1"
					data-id="uID"
					data-id-value="' . $this->gallery_model->image['id'] . '"
					data-pk="uID"
					data-pk-value="' . $this->gallery_model->image['id'] . '"
					data-title-activate="' . tr ( '_GLOBAL_activate_tooltip_' ) . '"
					data-title-desactivate="' . tr ( '_GLOBAL_desactivate_tooltip_' ) . '"
					title="' . tr ( '_GLOBAL_desactivate_tooltip_' ) . '"
					>
					<i class="glyphicon glyphicon-ok"></i>
				    </button>
				    <button
					class="btn  btn-sm btn-primary modal-ajax"
					data-url="' . backend_url ( array( 'gallery', 'image-edit', $this->gallery_model->image['id'] ) ) . '"
					data-modal-id="#image-edit-' . $this->gallery_model->image['id'] . '"
					title="' . tr ( '_GLOBAL_edit_' ) . '"
					>
					<i class="glyphicon glyphicon-edit"></i>
				    </button>
				    <button
					class="btn btn-sm btn-danger dialog-ajax"
					data-url="' . backend_url ( array( 'gallery', 'image-delete', $this->gallery_model->image['id'] ) ) . '"
					data-message="<img src=\'' . $this->template->thumb ( 'uploads', $this->gallery_model->image['url'], array( 'w' => 600, 'h' => 400, 'type' => 'stretch' ) ) . '\' class=\'img-responsive\'>"
					data-title="' . tr ( '_GLOBAL_DIALOG_DELETE_GALLERY_IMAGE_title_' ) . '"
					data-confirm-label="' . tr ( '_GLOBAL_confirm_' ) . '"
					data-cancel-label="' . tr ( '_GLOBAL_cancel_' ) . '"
					data-delete-shuffle-container="#gallery-container"
					data-delete-shuffle-element="#element-' . $this->gallery_model->image['id'] . '"
					title="' . tr ( '_GLOBAL_delete_' ) . '"
					>
					<i class="glyphicon glyphicon-trash"></i>
				    </button>
				</div>
			    </div>
			    <img src="' . $this->template->thumb ( 'uploads', $this->gallery_model->image['url'], array( 'w' => 400, 'h' => 300, 'type' => 'stretch' ) ) . '" alt="image_' . $this->gallery_model->image['url'] . '" class="img-responsive" />
			</div>
		    </div>';
	    }
	    else
	    {

		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_BACKEND_GALLERY_ERROR_saving_image_to_db_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function image_edit ( $uID = NULL )
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
		$this->form_validation->set_rules ( 'category[]', '"' . tr ( '_GLOBAL_category_' ) . '"', 'required|max_length[255]|trim' );

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
			'category[]' => form_error ( 'category[]' ) ? 'has-error' : 'has-success'
		    );
		}
		else
		{
		    // Load library
		    $this->load->model ( 'backend/gallery_model' );

		    // Form Values
		    $form['uID'] = $uID;
		    $form['category'] = implode ( ',', $this->input->post ( 'category[]', TRUE ) );
		    $form['images'] = $this->input->post ( 'images', TRUE );

		    if ( $this->gallery_model->image_edit ( $form ) )
		    {
			$json['status'] = TRUE;
			$json['message'] = tr ( '_PAGE_BACKEND_GALLERY_SUCCESS_edit_image_' );
			$json['shuffle_id'] = $uID;
			$json['shuffle_value'] = $form['category'];
		    }
		    else
		    {
			$json['status'] = FALSE;
			$json['message'] = tr ( '_PAGE_BACKEND_GALLERY_ERROR_edit_image_' );
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
		$this->load->model ( 'backend/gallery_model' );

		// Load Translation
		$data['data'] = $this->gallery_model->image_get ( $uID );
		$data['categories'] = $this->gallery_model->categories_get ();

		// Load View
		$this->template->view ( 'gallery/modal/_image_edit', $data );
	    }
	}
    }

    public function image_delete ( $uID )
    {

	if ( !isset ( $uID ) || !is_numeric ( $uID ) )
	{
	    show_404 ();
	}

	// Load Model
	$this->load->model ( 'backend/gallery_model' );

	// Get image name
	$image = $this->gallery_model->image_get_url ( $uID );

	// Delete odl image
	$this->template->delete ( 'uploads', $image );

	if ( $this->gallery_model->image_delete ( array( 'uID' => $uID ) ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_PAGE_BACKEND_GALLERY_IMAGE_SUCCESS_delete_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_PAGE_BACKEND_GALLERY_IMAGE_ERROR_delete_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

}
