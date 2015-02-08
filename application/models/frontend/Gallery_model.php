<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Gallery_model extends CI_Model
{

    /**
     * Constructor de la clase
     *
     * @access 	public
     */
    public function __construct ()
    {
	//$this->output->enable_profiler ( TRUE );
    }

    public function get_one ( $uID = NULL )
    {
	$resultado = $this
		->db
		->select ( 'a.url' )
		->from ( 'galeria_images a' )
		->where ( 'a.uID_estados', 1 )
		->where ( ' FIND_IN_SET(\'' . $uID . '\', a.uID_galeria) !=', 0 )
		->limit ( 1 )
		->order_by ( 'a.order ASC, a.uID ASC' )
		->get ()
		->row_array ();

	return $resultado['url'];
    }

    public function get_gallery ( $uID = NULL )
    {
	$resultado = $this
		->db
		->select ( 'a.url, b.title, b.text' )
		->from ( 'galeria_images a' )
		->join ( 'galeria_images_info b', 'a.uID = b.uID_galeria_images AND b.uID_idiomas = ' . $this->settings_model->language['uID'], 'left' )
		->where ( 'a.uID_estados', 1 )
		->where ( ' FIND_IN_SET(\'' . $uID . '\', a.uID_galeria) !=', 0 )
		->order_by ( 'a.order ASC, a.uID ASC' )
		->get ()
		->result_array ();

	return $resultado;
    }

}
