<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Gallery_model extends CI_Model
{

    public $image;

    /**
     * Añadir imagen a la galería
     *
     * @access 	public
     * @param 	array 	$image	    Información de la imágen
     * @return 	bool		    Devuelve TRUE si se ha podido añadir o FALSE si no se ha podido.
     */
    public function image_add ( $image = array() )
    {
	$add = array(
	    'uID_estados' => 1,
	    'uID_galeria' => 0,
	    'url' => $image['db_name'],
	    'order' => 1
	);

	$insert = $this->db->insert ( 'galeria_images', $add );

	$this->image['id'] = $this->db->insert_id ();
	$this->image['url'] = $image['db_name'];

	return $insert;
    }

    /**
     * Borrar imágen de la galería
     *
     * @access 	public
     * @param 	array 	$delete     Filtros a aplicar en la consulta
     * @return 	bool		    Devuelve TRUE si se ha podido borrar o FALSE si no se ha podido.
     */
    public function image_delete ( $delete = array() )
    {
	return $this->db->delete ( 'galeria_images', $delete );
    }

    /**
     * Editar imagen
     *
     * @access 	public
     * @param 	array 	$form	    Datos del formulario
     * @return 	bool                Devuelve TRUE si se ha podido editar o FALSE si no se ha podido.
     */
    public function image_edit ( $form = array() )
    {
	$update = array(
	    'uID_galeria' => $form['category']
	);

	$where = array(
	    'uID' => $form['uID']
	);

	if ( $this->db->update ( 'galeria_images', $update, $where ) )
	{
	    foreach ( get_languages ( TRUE ) as $language )
	    {
		$insert_info[] = array(
		    'uID_idiomas' => $language['uID'],
		    'uID_galeria_images' => $form['uID'],
		    'title' => $form['images'][$language['uID']]['title'],
		    'text' => $form['images'][$language['uID']]['text'],
		);
	    }

	    $this->db->insert_batch ( 'galeria_images_info', $insert_info );

	    foreach ( $form['images'] as $language_id => $image )
	    {

		$update = array(
		    'title' => $image['title'],
		    'text' => $image['text']
		);

		// Where
		$where = array(
		    'uID_galeria_images' => $form['uID'],
		    'uID_idiomas' => $language_id
		);

		if ( $this->db->update ( 'galeria_images_info', $update, $where ) )
		{
		    continue;
		}
		else
		{
		    return FALSE;
		}
	    }

	    return TRUE;
	}

	return FALSE;
    }

    /**
     * Obtiene una imagen para editar
     *
     * @access 	public
     * @param 	int 	$uID	ID de la imágen
     * @return 	array		Devuelve el array con la imagen, categoria y traducciones.
     */
    public function image_get ( $uID = NULL )
    {
	$return = $this
		->db
		->select ( '
			    a.uID	    AS	id,
			    a.uID_galeria   AS	gallery_id,
			    a.uID_estados   AS	status_id,
			    a.url

			  ' )
		->from ( 'galeria_images AS a' )
		->where ( 'a.uID', $uID )
		->order_by ( 'a.order ASC, a.uID ASC' )
		->get ()
		->row_array ();

	$translations = $this
		->db
		->select ( '
	                    a.uID		    AS	id,
			    a.uID_idiomas	    AS	language_id,
			    b.text		    AS	language,
			    a.title,
			    a.text
			' )
		->from ( 'galeria_images_info a' )
		->join ( 'idiomas b', 'a.uID_idiomas = b.uID', 'left' )
		->where ( 'a.uID_galeria_images', $return['id'] )
		->get ()
		->result_array ();

	if ( isset ( $translations ) && !empty ( $translations ) )
	{

	    foreach ( $translations as $translation )
	    {
		$return['images'][$translation['language_id']] = array(
		    'id' => $translation['id'],
		    'title' => $translation['title'],
		    'text' => $translation['text']
		);
	    }
	}
	return $return;
    }

    /**
     * Obtenemos la URL de una imágen x ID
     *
     * @access 	public
     * @param 	array 	$uID	uID de la imagen
     * @return 	string		Devuelve un string con la url
     */
    public function image_get_url ( $uID = NULL )
    {
	$image = $this->db
		->select ( 'a.url' )
		->from ( 'galeria_images a' )
		->where ( 'a.uID ', $uID )
		->limit ( 1 )
		->get ()
		->row_array ();

	return $image['url'];
    }

    /**
     * Obentemos todas las categorías de la galería
     *
     * @access 	public
     * @param 	int 	$uID        ID de la gelería a filtrar
     * @return 	array               Array con las categorías
     */
    public function categories_get ( $uID = NULL )
    {
	return $this
			->db
			->select ( '
				    a.uID	    AS	id,
				    a.nombre	    AS	name
			    ' )
			->from ( 'galeria a' )
			->order_by ( 'a.uID' )
			->get ()
			->result_array ();
    }

    /**
     * Obentemos todas las imagenes
     *
     * @access 	public
     * @return 	array               Array con todas las imagénes
     */
    public function gallery_get ()
    {
	return $this
			->db
			->select ( '
				    a.uID	    AS	id,
				    a.uID_galeria   AS	gallery_id,
				    a.uID_estados   AS	status_id,
				    a.url,
				    a.order
			' )
			->from ( 'galeria_images a' )
			->order_by ( 'a.order ASC, a.uID ASC' )
			->get ()
			->result_array ();
    }

}
