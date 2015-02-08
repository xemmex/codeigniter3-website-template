<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

/**
 * Frontend Controller
 *
 * Standar public controller to all users
 *
 * @package    CodeIgniter
 * @subpackage Frontend_Controller
 * @category   cores
 * @version    1.0 <beta>
 * @author     Nicolás Martinez <info@nicojmb.com>
 * @link       http://nicojmb.com
 */
class Frontend_Controller extends CI_Controller
{

    public function __construct ( $themes_system = 'frontend' )
    {

	// Parent Method
	parent::__construct ();

	// Development Profiler
	if ( ENVIRONMENT == 'development' )
	{
	    $this->output->enable_profiler ( TRUE );
	}

	// Load Libraries
	$this->load->library ( 'user_agent' );

	// Load Drivers
	$this->load->driver ( 'session' );

	// Load Database
	$this->load->database ();

	// Load Helpers
	$this->load->helper ( 'route' );
	$this->load->helper ( 'auth' );
	$this->load->helper ( 'date' );
	$this->load->helper ( 'url' );
	$this->load->helper ( 'cookie' );
	$this->load->helper ( 'text_helper' );
	$this->load->helper ( 'form' );
	$this->load->helper ( 'pagination' );
	$this->load->helper ( 'translate' );
	$this->load->helper ( 'breadcrumb' );

	// Load Specific Models
	$this->load->model ( 'settings_model' );

	// Load System Config
	$this->settings_model->load ( 'system' );

	// Check if session is locked
	if ( is_locked () )
	{
	    redirect ( 'auth/locked' );
	}
	else
	{
	    // Otherwise update last activity
	    update_last_activity ();
	}

	// Load System Config
	$this->settings_model->load ( 'system' );

	// Load Other Model
	$this->load->model ( 'auth_model' );
	$this->load->model ( 'mailer_model' );
	$this->load->model ( 'translate_model' );

	// Load Library
	$this->load->library ( 'template', array(
	    'themes_system' => $themes_system,
	    'themes_default' => $this->settings_model->system['_system_theme_frontend_']
	) );
    }

}

/**
 * Auth Controller
 *
 * Controller to manage Auth model,
 *
 * @package    CodeIgniter
 * @subpackage Frontend_Controller
 * @category   cores
 * @version    1.0 <beta>
 * @author     Nicolás Martinez <info@nicojmb.com>
 * @link       http://nicojmb.com
 */
class Auth_Controller extends Frontend_Controller
{

    public function __construct ()
    {
	parent::__construct ( 'backend' );
    }

}

/**
 * Bakend Controller
 *
 * Controller to manage backend ui, neccesaru logged in.
 *
 * @package    CodeIgniter
 * @subpackage Frontend_Controller
 * @category   cores
 * @version    1.0 <beta>
 * @author     Nicolás Martinez <info@nicojmb.com>
 * @link       http://nicojmb.com
 */
class Backend_Controller extends Frontend_Controller
{

    public function __construct ()
    {
	parent::__construct ( 'backend' );

	// Checks if user is logged in
	if ( !is_logged_in () )
	{
	    $this->session->set_flashdata ( 'redirect', uri_string () );

	    if ( $this->input->is_ajax_request () )
	    {
		$this->output
			->set_header ( 'Content-Type: application/json; charset=utf-8' )
			->set_content_type ( 'application/json' );

		die ( json_encode ( array(
		    'status' => FALSE,
		    'message' => tr ( '_GLOBAL_user_not_logged_in_' ),
		    'redirect' => 'auth/login'
		) ) );
	    }
	    else
	    {
		redirect ( 'auth/login' );
	    }
	}

	// Checks permission table
	if ( check_pemission_table () === FALSE )
	{
	    if ( $this->input->is_ajax_request () )
	    {

		$this->output
			->set_header ( 'Content-Type: application/json; charset=utf-8' )
			->set_content_type ( 'application/json' );

		die ( json_encode ( array(
		    'status' => FALSE,
		    'message' => tr ( '_PAGE_BACKEND_HELPER_ERROR_not_permissions_' )
		) ) );
	    }
	    else
	    {
		show_404 ();
	    }
	}
    }

}
