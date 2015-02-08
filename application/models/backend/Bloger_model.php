<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Bloger_model extends CI_Model
{

    /**
     * Constructor de la clase
     *
     * @access    public
     */
    public function __construct ()
    {
	// $this->output->enable_profiler(TRUE);
	// Load Languuage
	$this->lang->load ( 'calendar' );
    }

    /**
     * Comprueba que la cateogira no este en uso antes de borrarla
     *
     * @access    public
     * @param    int $uID uID de la categoria
     * @return    bool            Devuelve TRUE si existe o FALSE si no existe.
     */
    public function category_in_use ( $uID = NULL )
    {
	$tr_key = $this->db->select ( 'uID' )->from ( 'blog' )->where ( 'uID_blog_categorias', $uID )->get ()->num_rows ();

	return ( $tr_key > 0 );
    }

    /**
     * Eliminar una categoría
     *
     * @access    public
     * @param    int $uID uID de la categoria
     * @return    bool            Devuelve TRUE si existe o FALSE si no existe.
     */
    public function category_delete ( $uID = NULL )
    {
	// Borramos el registro de la BD
	return $this->db->delete ( 'blog_categorias', array( 'uID' => $uID ) );
    }

    /**
     * Comprobar que la categoria exista
     *
     * @access    public
     * @param    string $name Nombre de la categoria a buscar
     * @return    bool            Devuelve TRUE si existe o FALSE si no existe.
     */
    public function category_exists ( $name = NULL )
    {
	$tr_key = $this->db->select ( 'texto' )->from ( 'blog_categorias' )->where ( 'texto', $name )->get ()->num_rows ();

	return ( $tr_key > 0 );
    }

    /**
     * Editar Categoria
     *
     * @access    public
     * @param    array $form Datos del formulario
     * @param    int $uID ID de la categoria
     * @return    bool                Devuelve TRUE si se ha añadido correctamente o FALSE si no se ha podido añadir.
     */
    public function category_edit ( $form = array(), $uID = NUL )
    {

	// Update DB field
	$update = array(
	    'texto' => $form['name']
	);


	// Where
	$where = array(
	    'uID' => $uID
	);


	if ( $this->db->update ( 'blog_categorias', $update, $where ) )
	{
	    foreach ( $form['translation'] as $language_id => $text )
	    {

		$update = array(
		    'texto' => $text
		);

		// Where
		$where = array(
		    'uID_blog_categorias' => $uID,
		    'uID_idiomas' => $language_id
		);

		if ( $this->db->update ( 'blog_categorias_info', $update, $where ) )
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
     * Añadir Categoria
     *
     * @access    public
     * @param    array $form Datos del formulario
     * @return    bool                Devuelve TRUE si se ha añadido correctamente o FALSE si no se ha podido añadir.
     */
    public function category_add ( $form = array() )
    {

	// Update DB field
	$insert = array(
	    'texto' => $form['name']
	);

	if ( $this->db->insert ( 'blog_categorias', $insert ) )
	{
	    $uID_blog_categorias = $this->db->insert_id ();

	    foreach ( get_languages ( TRUE ) as $language )
	    {
		$insert_info[] = array(
		    'uID_idiomas' => $language['uID'],
		    'uID_blog_categorias' => $uID_blog_categorias,
		    'texto' => $form['translation'][$language['uID']],
		);
	    }

	    return $this->db->insert_batch ( 'blog_categorias_info', $insert_info );
	}

	return FALSE;
    }

    /**
     * Obtenemos informacion de una categoría
     *
     * @access    public
     * @param    array $uID uID de la categoría
     * @return    bool                Devuelve TRUE si se ha añadido correctamente o FALSE si no se ha podido añadir.
     */
    public function category_get ( $uID = array() )
    {

	$return = $this->db->select ( '
			    a.uID		    AS id,
			    a.texto     	    AS text
			' )->from ( 'blog_categorias a' )->where ( 'a.uID', $uID )->get ()->row_array ();

	$categories = $this->db->select ( '
                            a.uID                   AS id,
			    a.uID_idiomas	    AS language_id,
                            a.texto                 AS text
			' )
		->from ( 'blog_categorias_info a' )
		->join ( 'idiomas b', 'a.uID_idiomas = b.uID', 'inner' )
		->where ( 'a.uID_blog_categorias', $uID )
		->get ()
		->result_array ();

	foreach ( $categories as $category )
	{
	    $return['translations'][$category['language_id']] = array(
		'id' => $category['id'],
		'text' => $category['text']
	    );
	}

	return $return;
    }

    /**
     * Obtenemos el archivo del Blog
     *
     * @access    public
     * @param    array $filtros Filtros a aplicar en la consulta
     * @param    array $return Variable de retorono de informacion
     * @return    array                Devuelve el array con los datos de la consulta
     */
    public function archive_get ( $filtros = array(), $return = array() )
    {
	$resultado = $this->db->select ( 'MONTHNAME(fecha_alta) as mes_string, MONTH(fecha_alta) as mes, YEAR(fecha_alta) as ano, COUNT(*) as total' )
		->from ( 'blog' )
		->join ( 'blog_info', 'blog.uID = blog_info.uID_blog' )
		->where ( 'blog_info.uID_idiomas', $this->settings_model->language['uID'] )
		->where ( 'uID_estados', 1 )
		->group_by ( 'ano, mes' )
		->order_by ( 'ano DESC, mes DESC, total DESC' );

	foreach ( $resultado->get ()->result_array () as $key => $val )
	{
	    $ano = $val['ano'];
	    $mes = str_pad ( $val['mes'], 2, "0", STR_PAD_LEFT );

	    $return[$ano][$mes] = array(
		'url' => backend_url ( array(
		    'bloger',
		    'entries-archive',
		    $ano,
		    $mes
		) ),
		'title' => $ano . '/' . $mes,
		'text' => $this->lang->line ( 'cal_' . strtolower ( $val['mes_string'] ) ) . ' (' . $val['total'] . ')'
	    );

	    unset ( $ano, $mes );
	}

	unset ( $ano, $mes, $val );

	return $return;
    }

    /**
     * Obtenemos las categorias disponibles del Blog
     *
     * @access    public
     * @param    array $filtros Filtros a aplicar en la consulta
     * @param    array $return Variable de retorono de informacion
     * @return    array                   Devuelve el array con los datos de la consulta
     */
    public function categories_get ( $filtros = array(), $return = array() )
    {
	$resultado = $this->db->select ( 'a.texto, COUNT(a.uID) AS total' )
		->from ( 'blog_categorias a' )
		->join ( 'blog_categorias_info b', 'a.uID = b.uID_blog_categorias' )
		->join ( 'blog c', 'a.uID =  c.uID_blog_categorias' )
		->where ( 'c.uID_estados', 1 )
		->where ( 'b.uID_idiomas', $this->settings_model->language['uID'] )
		->group_by ( 'a.uID' );

	foreach ( $resultado->get ()->result_array () as $key => $val )
	{
	    $return[] = array(
		'url' => backend_url ( array(
		    'bloger',
		    'entries-category',
		    url_title ( $val['texto'], '-', TRUE )
		) ),
		'text' => $val['texto'],
		'total' => $val['total']
	    );
	}

	unset ( $resultado, $key, $val );

	return $return;
    }

    /**
     * Obtiene todas las categorias del blog
     *
     * @access    public
     * @return    mixed            Devuelve el array con los datos de la consulta
     */
    public function categories_get_all ()
    {
	$sql = $this->db->select ( 'a.uID AS id, a.texto AS text' )
		->from ( 'blog_categorias a' )
		->order_by ( 'a.texto', 'asc' )
		->get ()
		->result_array ();

	return self::_parse_categories_get_all ( $sql );
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access    private
     * @param    array $data Array con todos los datos a parsear
     * @param    array $return Variable de retorono de informacion
     * @return    array            Devuelve el array con los datos formateados
     */
    public function _parse_categories_get_all ( $data = array(), $return = array() )
    {
	foreach ( $data as $key => $val )
	{
	    $return[] = array(
		'url_edit' => backend_url ( array(
		    'bloger',
		    'category-edit',
		    $val['id']
		) ),
		'url_delete' => backend_url ( array(
		    'bloger',
		    'category-delete',
		    $val['id']
		) ),
		'id' => $val['id'],
		'text' => $val['text']
	    );
	}

	unset ( $data, $key, $val );

	return $return;
    }

    /**
     * Borrar entrada
     *
     * @access    public
     * @param    int $uID ID del cliente
     * @return    bool        Devuelve el array con los datos de la consulta
     */
    public function entry_delete ( $uID = array() )
    {
	// Obtenemos los datos de la entrada
	$entry = self::entry_get_image ( $uID );

	// Borramos las imagenes asociadas
	$this->template->delete ( 'uploads', $entry['image'] );

	// Borramos el registro de la BD
	return $this->db->delete ( 'blog', array( 'uID' => $uID ) );
    }

    /**
     * Añadir entrada
     *
     * @access    public
     * @param    array $form Datos del formulario
     * @return    bool        Indica si el resultado es correcto o no
     */
    public function entry_add ( $form = array() )
    {
	// Update DB field
	$insert = array(
	    'uID_estados' => $form['status_id'],
	    'uID_blog_categorias' => $form['category_id'],
	    'uID_usuarios' => user ( 'uID' ),
	    'imagen' => $form['image'],
	    'comentarios' => 1,
	    'fecha_alta' => date ( 'Y-m-d H:i:s' )
	);

	if ( $this->db->insert ( 'blog', $insert ) )
	{
	    $uID_blog = $this->db->insert_id ();

	    foreach ( get_languages ( TRUE ) as $language )
	    {
		$insert_info[] = array(
		    'uID_idiomas' => $language['uID'],
		    'uID_blog' => $uID_blog,
		    'titulo' => $form['translations'][$language['uID']]['title'],
		    'texto' => $form['translations'][$language['uID']]['text'],
		);
	    }

	    return $this->db->insert_batch ( 'blog_info', $insert_info );
	}

	return FALSE;
    }

    /**
     * Editar entrada
     *
     * @access    public
     * @param    array $form Datos del formulario
     * @param    int $uID ID de la entrada a editar
     * @return    bool        Indica si el resultado es correcto o no
     */
    public function entry_edit ( $form = array(), $uID = NULL )
    {
	// Update DB field
	$update = array(
	    'fecha_mod' => date ( 'Y-m-d H:i:s' )
	);

	// Where
	$where = array(
	    'uID' => $uID
	);

	if ( $this->db->update ( 'blog', $update, $where ) )
	{
	    foreach ( $form['translations'] as $language_id => $translation )
	    {

		$update = array(
		    'titulo' => $translation['title'],
		    'texto' => $translation['text']
		);

		// Where
		$where = array(
		    'uID_blog' => $uID,
		    'uID_idiomas' => $language_id
		);

		if ( $this->db->update ( 'blog_info', $update, $where ) )
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
	else
	{
	    return FALSE;
	}
    }

    /**
     * Cambia la imagen del post del blog
     *
     * @access    public
     * @param    array $uID ID de la entrada
     * @param    array $image Nombre del archivo de imagen
     * @return    bool            Devuelve el array con los datos de la consulta
     */
    public function entry_change_image ( $uID = NULL, $image = NULL )
    {
	// Old Image
	$old_image = self::entry_get_image ( $uID );

	// Delete Previus Image
	$this->template->delete ( 'uploads', $old_image['image'] );

	// Update DB field
	$update = array(
	    'imagen' => $image
	);

	// Where
	$where = array(
	    'uID' => $uID
	);

	return $this->db->update ( 'blog', $update, $where );
    }

    /**
     * Obtiene las imagenes asociadas a una entrada
     *
     * @access    public
     * @param    array $uID ID de la entrada
     * @return    mixed            Devuelve el array con los datos de la consulta
     */
    public function entry_get_image ( $uID = NULL )
    {
	return $this->db->select ( 'imagen AS image' )->from ( 'blog' )->where ( 'uID', $uID )->get ()->row_array ();
    }

    /**
     * Obtenemos una entrada con todos los idiomas
     *
     * @access    public
     * @param    array $uID ID de la entrada
     * @param    bool $count Establecer a TRUE si solo desemas saber el nº de registros
     * @return    array               Devuelve el array con los datos de la consulta
     */
    public function entry_get ( $uID = NULL )
    {
	$return = $this->db->select ( '
			    a.uID		    AS id,
			    a.uID_estados	    AS status_id,
                            a.imagen                AS image,
                            b.uID                   AS category_id,
                            c.texto                 AS category
			' )
		->from ( 'blog a' )
		->join ( 'blog_categorias b', 'a.uID_blog_categorias = b.uID', 'inner' )
		->join ( 'blog_categorias_info c', 'b.uID = c.uID_blog_categorias', 'inner' )
		->where ( 'a.uID', $uID )
		->get ()
		->row_array ();

	$entries = $this->db->select ( '
                            a.uID                   AS id,
			    a.uID_idiomas	    AS language_id,
                            a.titulo                AS title,
                            a.texto                 AS text
			' )
		->from ( 'blog_info a' )
		->join ( 'idiomas b', 'a.uID_idiomas = b.uID', 'inner' )
		->where ( 'a.uID_blog', $uID )
		->get ()
		->result_array ();

	foreach ( $entries as $entry )
	{
	    $return['translations'][$entry['language_id']] = array(
		'id' => $entry['id'],
		'title' => $entry['title'],
		'text' => $entry['text']
	    );
	}

	return $return;
    }

    /**
     * Obtenemos todas las entradas del blog
     *
     * @access    public
     * @param    array $filtros Filtros a aplicar en la consulta
     * @param    bool $count Establecer a TRUE si solo desemas saber el nº de registros
     * @return    array               Devuelve el array con los datos de la consulta
     */
    public function entries_get ( $filtros = array(), $count = FALSE )
    {
	$resultado = $this->db->select ( 'a.uID, a.uID_estados, a.uID_usuarios, a.fecha_alta, a.fecha_mod, a.imagen, b.titulo, b.texto, c.nombre, c.apellido, e.uID AS category_id, f.texto AS categoria' )
		->from ( 'blog a' )
		->join ( 'blog_info b', 'a.uID = b.uID_blog AND b.uID_idiomas = ' . $this->settings_model->language['uID'], 'inner' )
		->join ( 'usuarios c', 'a.uID_usuarios  = c.uID', 'inner' )
		->join ( 'blog_categorias e', 'a.uID_blog_categorias = e.uID', 'inner' )
		->join ( 'blog_categorias_info f', 'e.uID = f.uID_blog_categorias AND f.uID_idiomas = ' . $this->settings_model->language['uID'], 'left' )
		->where ( 'b.uID_idiomas', $this->settings_model->language['uID'] )
		->order_by ( 'a.fecha_alta', 'desc' );


	if ( isset ( $filtros['search'] ) && !empty ( $filtros['search'] ) )
	{
	    $resultado->like ( 'b.titulo', $filtros['search'] );
	    $resultado->or_like ( 'b.texto', $filtros['search'] );
	    $resultado->or_like ( 'f.texto', $filtros['search'] );
	}

	if ( isset ( $filtros['category'] ) && !empty ( $filtros['category'] ) )
	{
	    $resultado->like ( 'f.texto', $filtros['category'] );
	}

	if ( isset ( $filtros['year'] ) && isset ( $filtros['month'] ) )
	{
	    $resultado->where ( 'YEAR(a.fecha_alta)', $filtros['year'] );
	    $resultado->where ( 'MONTH(a.fecha_alta)', $filtros['month'] );
	}

	if ( isset ( $filtros['limit'] ) && isset ( $filtros['start'] ) )
	{
	    $resultado->limit ( $filtros['limit'], $filtros['start'] );
	}

	if ( !$count )
	{
	    $resultado->group_by ( 'a.uID' );
	}

	return ( $count ) ? $resultado->count_all_results () : self::_entries_parse ( $resultado->get ()->result_array () );
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access    private
     * @param    array $data Array con todos los datos a parsear
     * @param    array $return Variable de retorono de informacion
     * @return    array            Devuelve el array con los datos formateados
     */
    private function _entries_parse ( $data = array(), $return = array() )
    {
	foreach ( $data as $key => $val )
	{
	    $return[] = array(
		'url_edit' => backend_url ( array(
		    'bloger',
		    'entry-edit',
		    $val['uID']
		) ),
		'url_delete' => backend_url ( array(
		    'bloger',
		    'entry-delete',
		    $val['uID']
		) ),
		'id' => $val['uID'],
		'status_id' => $val['uID_estados'],
		'date' => date ( 'd/m/Y H:i', strtotime ( $val['fecha_alta'] ) ),
		'date_mod' => date ( 'd/m/Y H:i', strtotime ( $val['fecha_mod'] ) ),
		'day' => date ( 'j', strtotime ( $val['fecha_alta'] ) ),
		'month' => $this->lang->line ( 'cal_' . strtolower ( date ( 'M', strtotime ( $val['fecha_alta'] ) ) ) ),
		'month_large' => $this->lang->line ( 'cal_' . strtolower ( date ( 'F', strtotime ( $val['fecha_alta'] ) ) ) ),
		'year' => date ( 'Y', strtotime ( $val['fecha_alta'] ) ),
		'title' => $val['titulo'],
		'text' => $val['texto'],
		'imagen' => $val['imagen'],
		'category' => $val['categoria'],
		'category_id' => $val['category_id'],
		'user_name' => $val['nombre'],
		'user_url' => backend_url ( array(
		    'user',
		    'public',
		    $val['uID_usuarios']
		) )
	    );
	}

	unset ( $data, $key, $val );

	return $return;
    }

}
