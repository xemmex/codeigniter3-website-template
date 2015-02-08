<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

/**
 * CodeIgniter Route Helper
 *
 * @package	CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author      Nicolás Martinez
 * @link        http://www.nicojmb.com/ci/3.0/helpers/traductor.html
 */
/**
 * is_active()
 * Check if URL is active
 *
 * @author 	Nicolás Martinez
 * @param 	string $class
 * @return 	string
 */
if ( !function_exists ( 'is_active' ) )
{

    /**
     * Check if URL is active
     *
     * Accepts one string parameter to search in database translations
     *
     * @param	string	$uri	    URL to check if is active
     * @param	string	$class	    Class string to return
     * @return	string
     */
    function is_active ( $uri = '', $class = ' class="active"' )
    {

	if ( class_exists ( 'CI_Controller' ) )
	{
	    $_ci = & get_instance ();
	    $lang = $_ci->settings_model->language['code'];
	    $only_uri = $_ci->uri->uri_string ();
	    $uri_string = implode ( '/', $uri );
	    $url_string = $_ci->uri->uri_string ();

	    if ( (!empty ( $uri ) && strpos ( $url_string, $uri_string ) !== false ) || ( ( empty ( $uri ) && $only_uri == $lang) || ( empty ( $uri ) && empty ( $only_uri ) ) ) )
	    {
		return $class;
	    }
	    else
	    {
		return '';
	    }
	}
    }

}

/**
 * CodeIgniter Route Helper
 *
 * @package	CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author      Nicolás Martinez
 * @link        http://www.nicojmb.com/ci/3.0/helpers/traductor.html
 */
/**
 * is_active_dropdown()
 * Check if Array of URLs are active
 *
 * @author 	Nicolás Martinez
 * @param 	string $class
 * @return 	string
 */
if ( !function_exists ( 'is_active_dropdown' ) )
{

    /**
     * Check if URL is active
     *
     * Accepts one string parameter to search in database translations
     *
     * @param	string	$uris	    ARRAY of URL to check if is active
     * @param	string	$class	    Class string to return
     * @return	string
     */
    function is_active_dropdown ( $uris = array(), $class = ' class="active"' )
    {
	foreach ( $uris as $uri )
	{
	    if ( is_active ( array( $uri ), $class ) )
	    {
		return $class;
	    }
	}
    }

}

/**
 * back_homepage()
 * Go to Home Page
 *
 * @author 	Nicolás Martinez
 * @param 	string $class
 * @return 	string
 */
if ( !function_exists ( 'back_homepage' ) )
{

    /**
     * Go to Home Page
     *
     * Go to home page in any controller
     *
     * @param	string	$uri	    URL to check if is active
     * @param	string	$protocol   Protocolo to return
     * @return	string
     */
    function back_homepage ( $uri = '', $protocol = NULL )
    {

	if ( class_exists ( 'CI_Controller' ) )
	{
	    return get_instance ()->config->site_url ( $uri, $protocol );
	}
    }

}

/**
 * switch_lang()
 * Change languange to selected
 *
 * @author 	Nicolás Martinez
 * @param 	string $class
 * @return 	string
 */
if ( !function_exists ( 'switch_lang' ) )
{

    /**
     * Change languange to selected
     *
     * @param	string	$uri	    URL to check if is active
     * @param	string	$protocol   Protocolo to return
     * @return	string
     */
    function switch_lang ( $uri = '', $protocol = NULL )
    {

	if ( class_exists ( 'CI_Controller' ) )
	{
	    $_ci = & get_instance ();
	    $uri_string = $_ci->uri->uri_string ();
	    $lang = $_ci->settings_model->language['code'];

	    if ( !empty ( $uri_string ) )
	    {
		$uri = str_replace ( '//', '/', $uri . '/' . preg_replace ( "/^$lang/", trim ( '', '/' ), $uri_string ) );
	    }
	    else
	    {
		$uri = $uri;
	    }
	}

	return $_ci->config->site_url ( $uri );
    }

}

/**
 * is_home()
 * Check if current controller is default
 *
 * @author 	Nicolás Martinez
 * @param 	string $class
 * @return 	string
 */
if ( !function_exists ( 'is_home' ) )
{

    /**
     * Change languange to selected
     *
     * @param	string	$class		Class string to return
     * @param	string	$controller	Name of default controller
     * @return	string
     */
    function is_home ( $class = ' class="active"', $controller = 'base' )
    {
	return get_instance ()->router->fetch_class () === $controller ? $class : '';
    }

}

/**
 * frontend_url()
 * Go to specidfic URL
 *
 * @author 	Nicolás Martinez
 * @param	string	$uri		URI to go
 * @param	string	$protocol	Protocol to USE
 * @param	string	$active_flag	Name of default controller
 * @param	string	$active_link	Link to assign in active uri
 * @return 	string
 */
if ( !function_exists ( 'frontend_url' ) )
{

    /**
     * Go to specidfic URL in Frontend
     *
     * @param	string	$uri		URI to go
     * @param	string	$protocol	Protocol to USE
     * @param	string	$active_flag	Name of default controller
     * @param	string	$active_link	Link to assign in active uri
     * @return	string
     */
    function frontend_url ( $uri = '', $protocol = NULL, $active_flag = FALSE, $active_link = 'javascript:void(0);' )
    {
	if ( is_array ( $uri ) )
	{
	    $uri = implode ( '/', $uri );
	}

	if ( class_exists ( 'CI_Controller' ) )
	{
	    $_ci = & get_instance ();
	    $segment = explode ( '/', $uri );
	    $lang = isset ( $_ci->settings_model->language['code'] ) ? $_ci->settings_model->language['code'] : NULL;

	    if ( isset ( $lang ) && $segment[0] == $lang )
	    {
		$uri = preg_replace ( "/^$segment[0]\//", '', $uri );
	    }

	    if ( isset ( $lang ) && !in_array ( $segment[0], array( 'backend', 'auth', 'admin' ) ) )
	    {
		$uri = $_ci->settings_model->language['code'] . '/' . $uri;
	    }
	}

	return (isset ( $uri ) && $active_flag === TRUE && is_active ( $uri ) ) ? $active_link : $_ci->config->site_url ( $uri, $protocol );
    }

}

/**
 * backend_url()
 * Go to specidfic URL
 *
 * @author 	Nicolás Martinez
 * @param	string	$uri		URI to go
 * @param	string	$protocol	Protocol to USE
 * @param	string	$active_flag	Name of default controller
 * @param	string	$active_link	Link to assign in active uri
 * @return 	string
 */
if ( !function_exists ( 'backend_url' ) )
{

    /**
     * Go to specidfic URL in Backend
     *
     * @param	string	$uri		URI to go
     * @param	string	$protocol	Protocol to USE
     * @param	string	$active_flag	Name of default controller
     * @param	string	$active_link	Link to assign in active uri
     * @return	string
     */
    function backend_url ( $uri = '', $protocol = NULL, $active_flag = FALSE, $active_link = 'javascript:void(0);' )
    {
	if ( is_array ( $uri ) )
	{
	    $uri = implode ( '/', $uri );
	}

	if ( class_exists ( 'CI_Controller' ) )
	{
	    $_ci = & get_instance ();
	    $segment = explode ( '/', $uri );
	    if ( !in_array ( $segment[0], array( 'backend', 'auth', 'admin' ) ) )
	    {
		$uri = 'backend' . '/' . $uri;
	    }
	}

	return (isset ( $uri ) && $active_flag === TRUE && is_active ( $uri ) ) ? $active_link : $_ci->config->site_url ( $uri, $protocol );
    }

}

/**
 * current_url()
 * Get Current URL String
 *
 * @author 	Nicolás Martinez
 * @return 	string
 */
if ( !function_exists ( 'current_url' ) )
{

    /**
     * Get Current URL String
     *
     * @return	string
     */
    function current_url ()
    {
	$_ci = & get_instance ();
	return $_ci->config->site_url ( $_ci->uri->uri_string () );
    }

}