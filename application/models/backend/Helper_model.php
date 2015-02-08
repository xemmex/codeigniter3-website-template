<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Helper_model extends CI_Model
{

    /**
     * Reordenar Registros
     *
     * @access 	public
     * @param 	array 	$elements   Array con los elementos a ordenar
     * @return 	array               Devuelve el array con los datos de la consulta
     */
    public function re_order ( $elements = array() )
    {
	foreach ( $elements[0] as $order => $element )
	{
	    if ( !$this->db->update ( $element['table'], array( $element['column'] => $order ), array( $element['id'] => $element['id_value'] ) ) )
	    {
		return FALSE;
	    }
	}

	return TRUE;
    }

    /**
     * Cambia el valor de un campo en formato lista
     *
     * @access 	public
     * @param 	string 	$table		Nombre de la tabla
     * @param 	string 	$column		Nombre de la key a borrar
     * @param 	string 	$value		Valor actual del estado (0-1)
     * @param 	string 	$id		Nombre de la key a modificar
     * @param 	string 	$id_value	Valor de la key a modifcar
     * @param 	string 	$pk		Nombre de la key primaria
     * @param 	string 	$pk_value	Valor de la key primaria
     * @return 	bool			Devuleve el resultado de la consulta
     */
    public function change_list ( $table, $column, $value, $id, $id_value, $pk = NULL, $pk_value = NULL )
    {

	$data = array(
	    $column => implode ( ',', $value )
	);

	$where = array(
	    $id => $id_value
	);

	return $this->db->update ( $table, $data, $where );
    }

    /**
     * Cambia el valor de un campo de editor
     *
     * @access 	public
     * @param 	string 	$table		Nombre de la tabla
     * @param 	string 	$column		Nombre de la key a borrar
     * @param 	string 	$value		Valor actual del estado (0-1)
     * @param 	string 	$id		Nombre de la key a modificar
     * @param 	string 	$id_value	Valor de la key a modifcar
     * @param 	string 	$pk		Nombre de la key primaria
     * @param 	string 	$pk_value	Valor de la key primaria
     * @return 	bool			Devuleve el resultado de la consulta
     */
    public function change_editor ( $table, $column, $value, $id, $id_value, $pk = NULL, $pk_value = NULL )
    {

	$data = array(
	    $column => $value
	);

	$where = array(
	    $id => $id_value,
	    $pk => $pk_value
	);

	return $this->db->update ( $table, $data, $where );
    }

    /**
     * Cambia el valor de un campo
     *
     * @access 	public
     * @param 	string 	$table		Nombre de la tabla
     * @param 	string 	$column		Nombre de la key a borrar
     * @param 	string 	$value		Valor actual del estado (0-1)
     * @param 	string 	$id		Nombre de la key a modificar
     * @param 	string 	$id_value	Valor de la key a modifcar
     * @param 	string 	$pk		Nombre de la key primaria
     * @param 	string 	$pk_value	Valor de la key primaria
     * @return 	bool			Devuleve el resultado de la consulta
     */
    public function change_value ( $table, $column, $value, $id, $id_value, $pk = NULL, $pk_value = NULL )
    {

	$data = array(
	    $column => $value
	);

	$where = array(
	    $id => $id_value
	);

	return $this->db->update ( $table, $data, $where );
    }

    /**
     * Cambia el estado de un registro (activo / inactivo)
     *
     * @access 	public
     * @param 	string 	$table		Nombre de la tabla
     * @param 	string 	$column		Nombre de la key a borrar
     * @param 	string 	$value		Valor actual del estado (0-1)
     * @param 	string 	$id		Nombre de la key a modificar
     * @param 	string 	$id_value	Valor de la key a modifcar
     * @param 	string 	$pk		Nombre de la key primaria
     * @param 	string 	$pk_value	Valor de la key primaria
     * @return 	bool			Devuleve el resultado de la consulta
     */
    public function change_status ( $table, $column, $value, $id, $id_value, $pk = NULL, $pk_value = NULL )
    {

	$data = array(
	    $column => (( int ) $value === 1) ? 0 : 1
	);

	$where = array(
	    $id => $id_value,
	    $pk => $pk_value
	);

	return $this->db->update ( $table, $data, $where );
	// echo $this->db->last_query ();
    }

    /**
     * Cambia el estado por defecto de un registro
     *
     * @access 	public
     * @param 	string 	$table		Nombre de la tabla
     * @param 	string 	$column		Nombre de la key a borrar
     * @param 	string 	$id		Nombre de la key a modificar
     * @param 	string 	$id_value	Valor de la key a modifcar
     * @param 	string 	$pk		Nombre de la key primaria
     * @param 	string 	$pk_value	Valor de la key primaria
     * @return 	bool			Devuleve el resultado de la consulta
     */
    public function change_default ( $table, $column, $id, $id_value, $pk = NULL, $pk_value = NULL )
    {

	if ( isset ( $pk ) && isset ( $pk_value ) )
	{
	    $disable = array(
		$column => 1,
		$pk => $pk_value
	    );
	}
	else
	{
	    $disable = array(
		$column => 1
	    );
	}

	$enable = array(
	    $id => $id_value
	);

	if ( !$this->db->update ( $table, array( $column => 0 ), $disable ) )
	{
	    return FALSE;
	}
	else
	{
	    return $this->db->update ( $table, array( $column => 1 ), $enable );
	}
    }

}
