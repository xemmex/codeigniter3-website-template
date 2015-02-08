<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );



if ( !function_exists ( 'update_last_activity' ) )
{

    function update_last_activity ()
    {
	// Codeigniter Instance
	$_ci = &get_instance ();

	// Load library
	$_ci->load->model ( 'auth_model' );

	return $_ci->auth_model->update_last_activity ();
    }

}

if ( !function_exists ( 'is_offline' ) )
{

    function is_offline ()
    {
	// Codeigniter Instance
	$_ci = &get_instance ();

	// Load library
	$_ci->load->model ( 'auth_model' );

	return $_ci->auth_model->offline ();
    }

}


if ( !function_exists ( 'is_frontend' ) )
{

    function is_frontend ()
    {
	// Codeigniter Instance
	$_ci = &get_instance ();

	foreach ( array( 'backend', 'admin' ) as $controller )
	{
	    if ( strpos ( $_ci->uri->uri_string (), $controller ) !== FALSE )
	    {
		return false;
	    }
	}

	return true;
    }

}


if ( !function_exists ( 'is_locked' ) )
{

    function is_locked ()
    {
	if ( is_logged_in () && is_offline () )
	{
	    // Codeigniter Instance
	    $_ci = &get_instance ();

	    foreach ( array( 'auth/locked', 'auth/logout' ) as $controller )
	    {
		if ( strpos ( $_ci->uri->uri_string (), $controller ) !== FALSE )
		{
		    return FALSE;
		}
	    }

	    return TRUE;
	}

	return FALSE;
    }

}



if ( !function_exists ( 'is_logged_in' ) )
{

    function is_logged_in ()
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	if ( ( bool ) $_ci->session->userdata ( 'is_logged_in' ) === TRUE )
	{
	    return TRUE;
	}
	else
	if ( get_cookie ( 'remember_id' ) && get_cookie ( 'remember_token' ) )
	{
	    // Load library
	    $_ci->load->model ( 'auth_model' );

	    return ( $_ci->auth_model->login_from_cookie ( get_cookie ( 'remember_token' ) ) );
	}

	return FALSE;
    }

}

if ( !function_exists ( 'check_pemission_table' ) )
{

    function check_pemission_table ()
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	$_ci->load->model ( 'auth_model' );

	$controller = ucfirst ( $_ci->router->fetch_class () );

	foreach ( $_ci->auth_model->table as $table )
	{
	    if ( isset ( $controller ) && $controller == $table['Controller'] )
	    {
		return TRUE;
	    }
	    else
	    {
		continue;
	    }
	}

	return FALSE;
    }

}

if ( !function_exists ( 'check_pemission_controller' ) )
{

    function check_pemission_controller ( $controller = NULL )
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	$_ci->load->model ( 'auth_model' );

	foreach ( $_ci->auth_model->table as $table )
	{
	    if ( isset ( $controller ) && $controller == $table['Controller'] )
	    {
		return TRUE;
	    }
	    else
	    {
		continue;
	    }
	}

	return FALSE;
    }

}


if ( !function_exists ( 'is_profile' ) )
{

    function is_profile ( $permissions = '_client_' )
    {
	if ( is_string ( $permissions ) )
	{
	    switch ( $permissions )
	    {
		case '_client_' : $permissions = 1;
		    break;
		case '_employee_': $permissions = 3;
		    break;
		case '_manager_': $permissions = 4;
		    break;
		case '_admin_': $permissions = 5;
		    break;
		default :$permissions = 1;
		    break;
	    }
	}

	if ( !isset ( $permissions ) || empty ( $permissions ) || !is_int ( $permissions ) )
	{
	    return FALSE;
	}
	else
	{

	    // Codeigniter Instance
	    $_ci = &get_instance ();

	    // Load library
	    $_ci->load->model ( 'auth_model' );

	    return ( ( int ) $_ci->auth_model->user['permissions'] === ( int ) $permissions );
	}
    }

}

if ( !function_exists ( 'user' ) )
{

    function user ( $var = NULL )
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	$_ci->load->model ( 'auth_model' );

	$var = ($var === 'id') ? 'uID' : $var;

	if ( (isset ( $var ) && isset ( $_ci->auth_model->user[$var] ) ) )
	{
	    return $_ci->auth_model->user[$var];
	}
	else
	if ( isset ( $var ) )
	{
	    return '';
	}
	else
	{
	    return $_ci->auth_model->user;
	}
    }

}

if ( !function_exists ( 'get_permissions' ) )
{

    function get_permissions ()
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	// return
	$return = array();

	foreach ( $_ci->settings_model->permissions as $permission_id => $permission )
	{
	    if ( is_profile ( '_admin_' ) === TRUE || $permission_id < user ( 'permissions' ) )
	    {
		$return[$permission_id] = tr ( '_GLOBAL' . $permission );
	    }
	}

	return $return;
    }

}

if ( !function_exists ( 'get_status' ) )
{

    function get_status ()
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	// return
	$return = array();

	foreach ( $_ci->settings_model->status as $status_id => $status )
	{
	    $return[$status_id] = tr ( '_GLOBAL' . $status );
	}

	return $return;
    }

}