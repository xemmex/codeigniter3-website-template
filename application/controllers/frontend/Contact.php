<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Contact extends Frontend_Controller
{

    public function index ()
    {

	$data['seo_description'] = tr ( '_SEO_CONTACT_description_' );
	$data['seo_keywords'] = tr ( '_SEO_CONTACT_keywords_' );
	$data['seo_title'] = tr ( '_SEO_CONTACT_title_' );

	if ( $this->input->post ( 'contact_form' ) )
	{
	    // Library
	    $this->load->library ( 'form_validation' );

	    // Validation Rules for Password Form
	    $this->form_validation->set_rules ( 'name', ' "' . tr ( '_GLOBAL_name_' ) . '" ', 'required|trim' );
	    $this->form_validation->set_rules ( 'email', ' "' . tr ( '_GLOBAL_email_' ) . '" ', 'required|valid_email|trim' );
	    $this->form_validation->set_rules ( 'phone', ' "' . tr ( '_GLOBAL_phone_' ) . '" ', 'required|numeric|trim' );
	    $this->form_validation->set_rules ( 'message', ' "' . tr ( '_GLOBAL_message_' ) . '" ', 'required|trim' );

	    // Form Error Content
	    $this->form_validation->set_error_delimiters ( '', '<br>' );

	    // Check Validation
	    if ( !$this->form_validation->run () )
	    {
		// Message Data
		$data['contacto_form_class'] = 'error';
		$data['contacto_form_error'] = validation_errors ();
		$data['seo_title'] = tr ( '_PAGE_CONTACT_FORM_SEND_ERROR_title_' );
	    }
	    else
	    {
		// Form Data
		$form['name'] = $this->input->post ( 'name', TRUE );
		$form['email'] = $this->input->post ( 'email', TRUE );
		$form['phone'] = $this->input->post ( 'phone', TRUE );
		$form['message'] = $this->input->post ( 'message', TRUE );

		// Load E-mail Model
		$this->load->model ( 'mailer_model' );

		if ( $this->mailer_model->send ( 1, $form ) )
		{
		    // SUCCESS
		    $data['contacto_form_class'] = 'success';
		    $data['contacto_form_error'] = tr ( '_PAGE_CONTACT_FORM_SEND_SUCCESS_message_' );
		    $data['seo_title'] = tr ( '_PAGE_CONTACT_FORM_SEND_SUCCESS_title_' );
		}
		else
		{
		    // ERROR
		    $data['contacto_form_class'] = 'error';
		    $data['contacto_form_error'] = tr ( '_PAGE_CONTACT_FORM_SEND_ERROR_SEND_MAIL_message_' );
		    $data['seo_title'] = tr ( '_PAGE_CONTACT_FORM_SEND_ERROR_SEND_MAIL_title_' );
		}
	    }
	}

	// Render Template & Views
	$this->template->set ( 'js', '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?&sensor=true"></script>', TRUE )
		->set ( 'views', 'contact/index' )
		->set ( 'data', $data )
		->render ();
    }

}
