<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Newsletter_model extends CI_Model
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

    /**
     * Creamos un registro en la BBDD con el nuevo email de newsletter
     *
     * @access 	public
     * @param 	string	$email		E-mail del cliente
     * @param 	string	$servicio	Tipo de servicios del newslleter
     * @return 	array			Devuelve el array con los datos de la consulta
     */
    public function add ( $email = '', $servicio = 'default' )
    {

	$data = array(
	    'uID_estados' => 1,
	    'fecha_alta' => date ( 'Y-m-d H:i:s' ),
	    'email' => $email,
	    'servicio' => $servicio
	);

	return $this->db->replace ( 'emails_newsletter', $data );
    }

    /**
     * Eliminamos un registro en la BBDD con el nuevo email de newsletter
     *
     * @access 	public
     * @param 	string	$email		E-mail del cliente
     * @param 	string	$servicio	Tipo de servicios del newslleter
     * @return 	array			Devuelve el array con los datos de la consulta
     */
    public function remove ( $email = '', $servicio = 'default' )
    {

	$data = array(
	    'uID_estados' => 1,
	    'fecha_alta' => date ( 'Y-m-d H:i:s' ),
	    'email' => $email,
	    'servicio' => $servicio
	);

	return $this->db->replace ( 'emails_newsletter', $data );
    }

}
