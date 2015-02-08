<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Page_model extends CI_Model
{

    /**
     * Constructor de la clase
     *
     * @access 	public
     */
    public function __construct ()
    {
	// $this->output->enable_profiler ( TRUE );
    }

    public function get_page ( $uID = NULL )
    {
	$resultado = $this
		->db
		->select ( 'a.texto, a.template' )
		->from ( 'menus a' )
		->where ( 'a.uID_estados', 1 )
		->where ( 'a.uID', $uID )
		->get ()
		->row_array ();

	return array( 'page' => url_title ( $resultado['texto'], '_', TRUE ), 'template' => $resultado['template'] );
    }

    public function get_menus ( $position = 'navbar' )
    {
	$resultado = $this
		->db
		->select ( 'a.uID, a.texto, a.tipo, a.parent, a.external_link, a.attributes' )
		->from ( 'menus a' )
		->where ( 'a.uID_estados', 1 )
		->where ( 'a.on_' . $position, 1 )
		->order_by ( 'a.orden', 'asc' );

	return self::_parse_get_menus ( $resultado->get ()->result_array () );
    }

    private function _parse_get_menus ( $data = array(), $return = array() )
    {
	foreach ( $data as $val )
	{
	    if ( $val['tipo'] == 'title' )
	    {
		$return[$val['uID']]['text'] = url_title ( $val['texto'], '_', TRUE );
	    }
	    else
	    {
		$return[$val['parent']]['links'][$val['uID']]['active'] = array( 'page', $val['uID'], url_title ( $val['texto'], '-', TRUE ) );
		$return[$val['parent']]['links'][$val['uID']]['url'] = ( isset ( $val['external_link'] ) && !empty ( $val['external_link'] ) ) ? $val['external_link'] : frontend_url ( array( 'page', $val['uID'], url_title ( $val['texto'], '-', TRUE ) ) );
		$return[$val['parent']]['links'][$val['uID']]['attributes'] = $val['attributes'];
		$return[$val['parent']]['links'][$val['uID']]['text'] = url_title ( $val['texto'], '_', TRUE );
	    }
	}

	unset ( $data, $val );

	return $return;
    }

}
