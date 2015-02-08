<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class System_settings_model extends CI_Model
{

    /**
     * Actualizamos la tabla system_settings
     *
     * @access 	public
     * @param 	array 	$data	Array con la informacion a actualizar
     * @return 	bool		Devuelve el array con los datos de la consulta
     */
    public function update ( $form = array() )
    {
	foreach ( $form as $key => $value )
	{
	    if ( !$this->db->update ( 'system_settings', array( 'value' => $value ), array( 'key' => $key ) ) )
	    {
		return FALSE;
	    }
	}

	unset ( $form, $key, $value );

	return TRUE;
    }

}
