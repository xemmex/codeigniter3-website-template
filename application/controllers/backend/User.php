<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class User extends Backend_Controller
{

    public function index ()
    {
	backend_url ();
    }

    public function profile ()
    {

	if ( $this->input->is_ajax_request () )
	{
	    if ( $this->input->post ( 'user_profile_form' ) )
	    {
		self::_user_profile_form ();
	    }
	    else
	    if ( $this->input->post ( 'user_info_form' ) )
	    {
		self::_user_info_form ();
	    }
	    else
	    if ( $this->input->post ( 'user_password_form' ) )
	    {
		self::_user_password_form ();
	    }
	    else
	    {
		show_404 ();
	    }
	}
	else
	{
	    $data['seo_description'] = tr ( '_SEO_PAGE_USER_PROFILE_description_' );
	    $data['seo_keywords'] = tr ( '_SEO_PAGE_USER_PROFILE_keywords_' );
	    $data['seo_title'] = tr ( '_SEO_PAGE_USER_PROFILE_title_' );

	    $this->template
		    ->set ( 'views', 'user/profile' )
		    ->set ( 'data', $data )
		    ->render ();
	}
    }

    private function _user_profile_form ()
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'name', '"' . tr ( '_GLOBAL_name_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( 'lastname', '"' . tr ( '_GLOBAL_lastname_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( 'email', '"' . tr ( '_GLOBAL_email_' ) . '"', 'required|valid_email|trim' );
	$this->form_validation->set_rules ( 'email_repeat', '"' . tr ( '_GLOBAL_email_repeat_' ) . '"', 'required|valid_email|matches[email]|trim' );
	$this->form_validation->set_rules ( 'language', '"' . tr ( '_GLOBAL_language_' ) . '"', 'required' );

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
		'name' => form_error ( 'name' ) ? 'has-error' : 'has-success',
		'lastname' => form_error ( 'lastname' ) ? 'has-error' : 'has-success',
		'email' => form_error ( 'email' ) ? 'has-error' : 'has-success',
		'email_repeat' => form_error ( 'email_repeat' ) ? 'has-error' : 'has-success',
		'language' => form_error ( 'language' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{
	    // Load library
	    $this->load->model ( 'auth_model' );

	    // Form Values
	    $form['name'] = $this->input->post ( 'name', TRUE );
	    $form['lastname'] = $this->input->post ( 'lastname', TRUE );
	    $form['email'] = $this->input->post ( 'email', TRUE );
	    $form['language'] = $this->input->post ( 'language', TRUE );

	    // Check if user can login
	    if ( $this->auth_model->update_profile ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_USER_PROFILE_INFO_SUCCESS_update_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_USER_PROFILE_INFO_ERROR_update_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    private function _user_info_form ()
    {

	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'cargo', '"' . tr ( '_GLOBAL_cargo_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( 'vat', '"' . tr ( '_GLOBAL_vat_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( 'phone', '"' . tr ( '_GLOBAL_phone_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( 'mobile_phone', '"' . tr ( '_GLOBAL_mobile_phone_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( 'fax', '"' . tr ( '_GLOBAL_fax_' ) . '"', 'trim' );
	$this->form_validation->set_rules ( 'address', '"' . tr ( '_GLOBAL_address_' ) . '"' );
	$this->form_validation->set_rules ( 'description', '"' . tr ( '_GLOBAL_description_' ) . '"' );

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
		'cargo' => form_error ( 'cargo' ) ? 'has-error' : 'has-success',
		'vat' => form_error ( 'vat' ) ? 'has-error' : 'has-success',
		'phone' => form_error ( 'phone' ) ? 'has-error' : 'has-success',
		'mobile_phone' => form_error ( 'mobile_phone' ) ? 'has-error' : 'has-success',
		'fax' => form_error ( 'fax' ) ? 'has-error' : 'has-success',
		'address' => form_error ( 'address' ) ? 'has-error' : 'has-success',
		'description' => form_error ( 'description' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{
	    $avatar_folder = 'avatars/';
	    if ( $_FILES && isset ( $_FILES['avatar']['name'] ) )
	    {
		// Upload the file
		$config['upload_path'] = $this->template->path ( 'uploads', '', TRUE ) . '/' . $avatar_folder;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '500';
		$config['max_width'] = '141024';
		$config['max_height'] = '11768';

		$this->load->library ( 'upload', $config );

		if ( !$this->upload->do_upload ( 'avatar' ) )
		{
		    $json['status'] = FALSE;
		    $json['message'] = $this->upload->display_errors ();
		    $json['rules'] = array(
			'avatar' => 'has-error'
		    );
		    die ( json_encode ( $json ) );
		}
		else
		{

		    // Delete Previus avatar
		    $this->template->delete ( 'uploads', user ( 'avatar' ) );

		    // Image Info
		    $avatar = $this->upload->data ();
		}
	    }

	    // Load library
	    $this->load->model ( 'auth_model' );

	    // Form Values
	    $form['cargo'] = $this->input->post ( 'cargo', TRUE );
	    $form['vat'] = $this->input->post ( 'vat', TRUE );
	    $form['phone'] = $this->input->post ( 'phone', TRUE );
	    $form['mobile_phone'] = $this->input->post ( 'mobile_phone', TRUE );
	    $form['fax'] = $this->input->post ( 'fax', TRUE );
	    $form['address'] = $this->input->post ( 'address', TRUE );
	    $form['description'] = $this->input->post ( 'description', TRUE );

	    // Avatar
	    if ( (isset ( $avatar ) ) )
	    {
		$form['avatar'] = $avatar_folder . $avatar['file_name'];
	    }

	    // Check if user can login
	    if ( $this->auth_model->update_profile_extra_info ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_USER_PROFILE_INFO_SUCCESS_update_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_PAGE_USER_PROFILE_INFO_ERROR_update_' );
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    private function _user_password_form ()
    {
	// Library
	$this->load->library ( 'form_validation' );

	// Validation Rules
	$this->form_validation->set_rules ( 'old_password', '"' . tr ( '_GLOBAL_old_password_' ) . '"', 'required|trim' );
	$this->form_validation->set_rules ( 'new_password', '"' . tr ( '_GLOBAL_new_password_' ) . '"', 'required|trim|min_length[6]|password_check[1,1,1]' );
	$this->form_validation->set_rules ( 'new_password_repeat', '"' . tr ( '_GLOBAL_new_password_repeat_' ) . '"', 'required|matches[new_password]|trim' );

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
		'old_password' => form_error ( 'old_password' ) ? 'has-error' : 'has-success',
		'new_password' => form_error ( 'new_password' ) ? 'has-error' : 'has-success',
		'new_password_repeat' => form_error ( 'new_password_repeat' ) ? 'has-error' : 'has-success'
	    );
	}
	else
	{
	    // Load library
	    $this->load->model ( 'auth_model' );

	    // Form Values
	    $form['old_password'] = $this->input->post ( 'old_password', TRUE );
	    $form['new_password'] = $this->input->post ( 'new_password', TRUE );
	    $form['new_password_repeat'] = $this->input->post ( 'new_password_repeat', TRUE );

	    // Check if user can login
	    if ( $this->auth_model->change_password_from_profile ( $form ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_PAGE_USER_PROFILE_PASSWORD_SUCCESS_change_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['rules'] = array(
		    'old_password' => 'has-error',
		    'new_password' => 'has-success',
		    'new_password_repeat' => 'has-success'
		);
		$json['message'] = $this->auth_model->error;
	    }
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

}
