<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Settings_model extends CI_Model
{

    public $all_languages = array();
    public $languages = array();
    public $status = array();
    public $permissions = array();

    public function __construct ()
    {
	// Parent Method
	parent ::__construct ();
	self ::_load_languages ();
	self ::_load_status ();
	self ::_load_permissions ();
    }

    /**
     * Magic Method Set
     *
     * @access 	public
     */
    public function __set ( $name = NULL, $value = array() )
    {
	$this->$name = $value;

	unset ( $name, $value );
    }

    /**
     * Establecemos en las propiedades de la clase las configuraciones
     *
     * @access 	private
     * @param 	array 	$tabla 		Tabla de configuraciones a cargar
     * @param 	array 	$filtro 	Filtro de la consulta
     * @param 	array 	$multi 		Devuelve uno o mas registros segun el tipo de settings
     * @return 	void
     */
    public function load ( $tabla = '', $filtro = array(), $multi = FALSE )
    {
	if ( !property_exists ( 'Settings_model', $tabla ) )
	{
	    self::_parse_settings ( $tabla, $this->db->get ( $tabla . '_settings', $filtro )->result_array () );
	}

	unset ( $tabla, $filtro, $multi );
    }

    /**
     * Load Status
     *
     * @access 	private
     * @return 	void
     */
    private function _load_status ()
    {
	$statuses = $this->db->get_where ( 'estados' )->result_array ();

	foreach ( $statuses as $status )
	{
	    $this->status[$status['uID']] = $status['texto'];
	}

	unset ( $statuses, $status );
    }

    /**
     * Load Permissions
     *
     * @access 	private
     * @return 	void
     */
    private function _load_permissions ()
    {
	$permissions = $this->db->get_where ( 'usuarios_permisos' )->result_array ();

	foreach ( $permissions as $permission )
	{
	    $this->permissions[$permission['uID']] = $permission['texto'];
	}

	unset ( $permission, $permissions );
    }

    /**
     * Load Languages
     *
     * @access 	private
     * @return 	void
     */
    private function _load_languages ()
    {
	$browser_lang = !empty ( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ? substr ( strtok ( strip_tags ( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ), ',' ), 0, 2 ) : '';
	$this->all_languages = $this->db->from ( 'idiomas' )->order_by ( 'order', 'asc' )->get ()->result_array ();
	$languages = $this->db->from ( 'idiomas' )->where ( 'uID_estados', 1 )->order_by ( 'order', 'asc' )->get ()->result_array ();
	$lang_segment = $this->uri->segment ( 1 );
	$lang_session = $this->session->language;
	$lang_default = NULL;
	$lang_current = NULL;

	// Idiomas Disponibles
	foreach ( $languages as $idioma )
	{
	    $this->languages[$idioma['code']] = $idioma;

	    if ( $idioma['defecto'] == 1 )
	    {
		$lang_default = $idioma['code'];
	    }
	}

	if ( isset ( $lang_default ) && in_array ( $lang_segment, array( 'backend', 'auth' ) ) )
	{
	    $this->config->set_item ( 'language', $lang_default );
	    $this->__set ( 'language', $this->languages[$lang_default] );
	}
	else
	{

	    // Establecemos el idioma actual como el x defecto
	    $lang_current = $lang_default;

	    // Si recibimos peticion de idioma
	    if ( empty ( $lang_segment ) && isset ( $lang_session ) && !empty ( $lang_session ) )
	    {
		$lang_current = $lang_session;
	    }
	    else
	    if ( isset ( $this->languages[$lang_segment] ) )
	    {
		$lang_current = $lang_segment;
	    }
	    else
	    if ( isset ( $lang_session ) && !empty ( $lang_session ) )
	    {
		$lang_current = $lang_session;
	    }
	    else
	    if ( array_key_exists ( $browser_lang, $this->languages ) )
	    {
		$lang_current = $browser_lang;
	    }
	    else
	    if ( $lang_current != $lang_default )
	    {
		redirect ( $lang_default );
	    }

	    // Save Session
	    $this->session->set_userdata ( 'language', $lang_current );
	    $this->config->set_item ( 'language', $lang_current );
	    $this->__set ( 'language', $this->languages[$lang_current] );

	    unset ( $browser_lang, $languages, $lang_segment, $lang_session, $lang_default, $lang_current );
	}
    }

    /**
     * Genera un arrray con clave valor
     *
     * @access 	private
     * @param 	sring 	$tipo 		Nombre de objeto a crear
     * @param 	array 	$array 		Array a ordenar
     * @param 	array 	$return 	Variable de retorono de informacion
     * @return 	array 				Devuelve el array con la estructura correcta
     */
    private function _parse_settings ( $tipo = '', $array = array(), $multidimensional = TRUE, $return = array() )
    {
	if ( $multidimensional )
	{
	    foreach ( $array as $setting )
	    {
		$return[$setting['key']] = $setting['value'];
	    }
	}
	else
	{
	    $return = $array;
	}

	$this->__set ( $tipo, $return );

	unset ( $multidimensional, $array, $setting, $return );
    }

}
