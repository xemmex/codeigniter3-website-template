<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Translate_model extends CI_Model
{

    /**
     * KEYS las keys de las traducciones
     */
    public $keys = array();

    /**
     * SHOW_KEYS muestra las keys en vez de las traducciones
     */
    public $show_keys;

    /**
     * Constructor de la clase
     *
     * @access 	public
     */
    public function __construct ( $show_keys = FALSE )
    {
	// Default
	$this->show_keys = $this->settings_model->language['show_keys'];
	self::_translations ( TRUE );
    }

    /**
     * Gauarda las traducciones en una variable
     *
     * @access 	private
     * @param 	sring 	$array 		Array con variables del traductor
     * @param 	array 	$cache 		Si se quiere cacheaer las traducciones (optimiza el rendimiento)
     * @return 	void
     */
    private function _translations ( $cache = FALSE )
    {

	if ( $cache )
	{
	    $this->db->cache_on ();
	}

	$traductor = $this->db
		->select ( 'a.key, a.texto' )
		->from ( 'idiomas_traductor a' )
		->join ( 'idiomas b', 'a.uID_idiomas = b.uID' )
		->where ( 'b.uID', $this->settings_model->language['uID'] )
		->get ()
		->result_array ();

	if ( $cache )
	{
	    $this->db->cache_off ();
	}

	foreach ( $traductor as $i => $val )
	{
	    $this->keys[strtolower ( $val['key'] )] = $val['texto'];
	}

	unset ( $traductor, $i, $val, $cache );
    }

}
