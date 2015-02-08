<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Languages_model extends CI_Model
{

    /**
     * Comprobar que la key exista
     *
     * @access 	public
     * @param 	string 	$key	    Key buscar
     * @return 	bool		    Devuelve TRUE si existe o FALSE si no existe.
     */
    public function translation_exists ( $key = NULL )
    {
	$tr_key = $this->db
		->select ( 'key' )
		->from ( 'idiomas_traductor' )
		->where ( 'key', $key )
		->get ()
		->num_rows ();

	return ( $tr_key > 0 );
    }

    /**
     * Borrar Traduccion
     *
     * @access 	public
     * @param 	array 	$delete             Informacion a borrar
     * @param 	bool 	$all_languages	    Indica si se borra la traducción en todos los idiomas.
     * @return 	bool                        Devuelve TRUE si se ha borrado corectamente o FALSE si no se ha podido borrar.
     */
    public function translation_delete ( $delete = array(), $all_languages = FALSE )
    {

	if ( $all_languages )
	{

	    $translation = $this->db
		    ->select ( 'key' )
		    ->from ( 'idiomas_traductor' )
		    ->where ( $delete )
		    ->get ()
		    ->row_array ();

	    return $this->db->delete ( 'idiomas_traductor', array( 'key' => $translation['key'] ) );
	}
	else
	{
	    return $this->db->delete ( 'idiomas_traductor', $delete );
	}
    }

    /**
     * Añadir Traduccion
     *
     * @access 	public
     * @param 	array 	$form	    Datos del formulario
     * @return 	bool                Devuelve TRUE si se ha añadido correctamente o FALSE si no se ha podido añadir.
     */
    public function translation_add ( $form = array() )
    {
	foreach ( $form['translation'] as $language_id => $translation_text )
	{
	    $idiomas_traductor[] = array(
		'uID_idiomas' => $language_id,
		'key' => tr_key ( $form['key'] ),
		'texto' => tr_text ( $translation_text )
	    );
	}

	unset ( $form );

	$this->db->cache_delete_all ();

	return $this->db->insert_batch ( 'idiomas_traductor', $idiomas_traductor );
    }

    /**
     * Editar Traduccion
     *
     * @access 	public
     * @param 	array 	$form	    Datos del formulario
     * @return 	bool                Devuelve TRUE si se ha podido editar o FALSE si no se ha podido.
     */
    public function translation_edit ( $form = array() )
    {
	foreach ( $form['translations'] as $translation_id => $translation_text )
	{
	    $update = array(
		'key' => tr_key ( $form['key'] ),
		'texto' => tr_text ( $translation_text ),
		'fecha_actualizacion' => date ( 'Y-m-d H:i:s' )
	    );

	    $where = array(
		'uID' => $translation_id
	    );

	    if ( !$this->db->update ( 'idiomas_traductor', $update, $where ) )
	    {
		return FALSE;
	    }
	}

	$this->db->cache_delete_all ();

	return TRUE;
    }

    /**
     * Obtiene una traduccion
     *
     * @access 	public
     * @param 	int 	$uID	ID de la traducción
     * @return 	array		Devuelve el array con las traducciones de una KEY en todos los idiomas.
     */
    public function translation_get ( $uID = NULL )
    {
	$return = $this
		->db
		->select ( 'key, uID_idiomas AS language_id' )
		->from ( 'idiomas_traductor' )
		->where ( 'uID', $uID )
		->get ()
		->row_array ();

	$return['id'] = $uID;

	$translations = $this
		->db
		->select ( '
	                    a.uID		    AS	id,
			    a.uID_idiomas	    AS	language_id,
			    b.text		    AS	language,
			    a.`key`,
			    a.texto		    AS	text
			' )
		->from ( 'idiomas_traductor a' )
		->join ( 'idiomas b', 'a.uID_idiomas = b.uID', 'inner' )
		->where ( 'a.key', $return['key'] )
		->get ()
		->result_array ();

	foreach ( $translations as $translation )
	{
	    $return['translations'][$translation['language_id']] = array(
		'id' => $translation['id'],
		'text' => $translation['text']
	    );
	}
	return $return;
    }

    /**
     * Obtenemos todas las traducciones
     *
     * @access 	public
     * @param 	array 	$filtros    Filtros a aplicar en la consulta
     * @param 	bool 	$count      Establecer a TRUE si solo desemas saber el nº de registros
     * @param 	bool 	$datatables Indica si el formato de salida es para datables server-side.
     * @return 	array               Devuelve el array con todas las traduciones en todos los idiomas.
     */
    public function translations_get ( $filtros = array(), $count = FALSE, $datatables = FALSE )
    {
	if ( $datatables === TRUE )
	{
	    // Load Datatables Library
	    $this->load->library ( 'datatables' );

	    // Get data from datatbles helper
	    $this->datatables
		    ->select ( '
			    a.`key`		    AS	translate_key,
			    (IF(LENGTH(a.texto) > 50, CONCAT(LEFT(a.texto, 50),\' ...\'), a.texto)) AS	text,
	                    a.uID		    AS	id
			', FALSE )
		    ->from ( 'idiomas_traductor a' )
		    ->join ( 'idiomas b', 'uID_idiomas = b.uID', 'inner' )
		    ->unset_column ( 'id' )
		    ->unset_column ( 'language_id' )
		    ->unset_column ( 'language' )
		    ->add_column ( 'key', '$1', 'translate_key' )
		    ->add_column ( 'text', '$1', 'text' )
		    ->add_column ( 'actions', '
			<button
			    class="btn btn-primary modal-ajax"
			    data-url="' . backend_url ( array( 'languages', 'translation-edit', '$1' ) ) . '"
			    data-modal-id="#translation-edit-$1"
			    title="' . tr ( '_GLOBAL_edit_' ) . '"
			    >
			    <i class="glyphicon glyphicon-edit"></i>
			</button>
                        <a  href="javascript:void(0);"
                            class="btn btn-danger dialog-ajax"
                            data-url="' . backend_url ( array( 'languages', 'translation-delete', '$1' ) ) . '"
                            data-message="<div class=\'note note-danger mb15\'>' . tr ( '_GLOBAL_DIALOG_DELETE_TRANSLATION_text_' ) . '</div><span class=\'label label-info\'>$2</span>"
                            data-title="' . tr ( '_GLOBAL_DIALOG_DELETE_TRANSLATION_title_' ) . '"
                            data-confirm-label="' . tr ( '_GLOBAL_confirm_' ) . '"
                            data-cancel-label="' . tr ( '_GLOBAL_cancel_' ) . '"
                            data-delete-datatables="true"
                            title="' . tr ( '_GLOBAL_delete_' ) . '"
                            >
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>', 'id, translate_key' );

	    if ( isset ( $filtros['uID'] ) && is_numeric ( $filtros['uID'] ) )
	    {
		$this->datatables->where ( 'a.uID_idiomas', $filtros['uID'] );
	    }

	    return $this->datatables->generate ();
	}
	else
	{
	    $sql = $this
		    ->db
		    ->select ( '
	                    a.uID		    AS	id,
			    a.uID_idiomas	    AS	language_id,
			    b.text		    AS	language,
			    a.`key`,
			    a.texto		    AS	text
			' )
		    ->from ( 'idiomas_traductor a' )
		    ->join ( 'idiomas b', 'a.uID_idiomas = b.uID', 'inner' )
		    ->order_by ( 'a.key', 'asc' );

	    if ( isset ( $filtros['uID'] ) && is_numeric ( $filtros['uID'] ) )
	    {
		$sql->where ( 'a.uID_idiomas', $filtros['uID'] );
	    }

	    return ( $count ) ? $sql->count_all_results () : self::_translations_parse ( $sql->get ()->result_array () );
	}
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access 	private
     * @param 	array 	$languages  Array con todos los idiomas disponibles
     * @param 	array 	$return	    Variable de retorono de informacion
     * @return 	array		    Devuelve el array con los datos formateados
     */
    private function _translations_parse ( $translations = array(), $single = FALSE, $return = array() )
    {

	foreach ( $translations as $translation )
	{

	    $return[$translation['language_id']]['language'] = $translation['language'];
	    $return[$translation['language_id']]['translation'][] = array(
		'url_delete' => backend_url ( array( 'languages', 'translation-delete', $translation['id'] ) ),
		'url_edit' => backend_url ( array( 'languages', 'translation-edit', $translation['id'] ) ),
		'id' => $translation['id'],
		'key' => $translation['key'],
		'text' => $translation['text'],
	    );
	}

	unset ( $translations, $translation );

	return ($single) ? $return[0] : $return;
    }

    /**
     * Borrar Idioma
     *
     * @access 	public
     * @param 	array 	$delete	    Condicion para borrar el idioma
     * @return 	bool		    Devuelve TRUE si se ha borrado corectamente o FALSE si no se ha podido borrar.
     */
    public function language_delete ( $delete = array() )
    {
	return $this->db->delete ( 'idiomas', $delete );
    }

    /**
     * Comprobar que el idioma exista
     *
     * @access 	public
     * @param 	string  $code   Codigo de idioma
     * @return 	bool            Devuelve TRUE si existe o FALSE si no existe.
     */
    public function language_exists ( $code = NULL )
    {
	$tr_lang = $this->db
		->select ( 'code' )
		->from ( 'idiomas' )
		->where ( 'code', $code )
		->get ()
		->num_rows ();

	return ( $tr_lang > 0 );
    }

    /**
     * Añadir Idioma
     *
     * @access 	public
     * @param 	array 	$form       Datos del formulario
     * @return 	bool                Devuelve TRUE si se ha podido añadir o FALSE si no se ha podido.
     */
    public function language_add ( $form = array() )
    {
	$data = array(
	    'uID_estados' => $form['status'],
	    'code' => strtolower ( $form['code'] ),
	    'text' => $form['text'],
	    'defecto' => 0,
	    'order' => count ( get_languages ( TRUE ) )
	);

	if ( $this->db->insert ( 'idiomas', $data ) )
	{
	    if ( isset ( $form['translations'] ) && !empty ( $form['translations'] ) )
	    {
		$uID_idiomas = $this->db->insert_id ();

		self::_copy_lang_translations ( $form['translations'], $uID_idiomas );
		self::_copy_blog_translations ( $form['translations'], $uID_idiomas );
		self::_copy_gallery_translations ( $form['translations'], $uID_idiomas );
		self::_copy_emails_templates ( $form['translations'], $uID_idiomas );
		self::_copy_file_translations ( $form['code'] );
	    }

	    return TRUE;
	}
	else
	{
	    return FALSE;
	}
    }

    /**
     * Obtenemos todos los idiomas disponibles
     *
     * @access 	public
     * @param 	array 	$filtros    Filtros a aplicar en la consulta
     * @param 	bool 	$count      Establecer a TRUE si solo desemas saber el nº de registros
     * @return 	array               Devuelve el array con todos los idiomas disponibles y sus datos.
     */
    public function languages_get ( $filtros = array(), $count = FALSE )
    {
	$sql = $this
		->db
		->select ( '
	                    a.uID		    AS id,
			    a.uID_estados	    AS status_id,
			    a.code,
			    a.text,
			    a.show_keys,
			    a.defecto		    AS default,
                            a.order,
                            b.texto		    AS status
			' )
		->from ( 'idiomas a' )
		->join ( 'estados b', 'a.uID_estados = b.uID', 'inner' )
		->order_by ( 'a.order', 'asc' );

	if ( isset ( $filtros['uID'] ) && is_numeric ( $filtros['uID'] ) )
	{
	    $sql->where ( 'a.uID', $filtros['uID'] );
	    $sql->limit ( 1 );
	}

	return ( $count ) ? $sql->count_all_results () : self::_languages_parse ( $sql->get ()->result_array (), (isset ( $filtros['uID'] )) ? TRUE : FALSE  );
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access 	private
     * @param 	array 	$languages  Array con todos los idiomas disponibles
     * @param 	array 	$return	    Variable de retorono de informacion
     * @return 	array		    Devuelve el array con los datos formateados
     */
    private function _languages_parse ( $languages = array(), $single = FALSE, $return = array() )
    {

	foreach ( $languages as $language )
	{
	    $return[] = array(
		'id' => $language['id'],
		//
		'url_delete' => backend_url ( array( 'languages', 'language-delete', $language['id'] ) ),
		'url_edit' => backend_url ( array( 'languages', 'language-edit', $language['id'] ) ),
		'url_translations' => backend_url ( array( 'languages', 'translations', $language['id'] ) ),
		//
		'status_id' => $language['status_id'],
		'status' => tr ( '_GLOBAL' . $language['status'] ),
		'show_keys' => $language['show_keys'],
		'code' => $language['code'],
		'text' => $language['text'],
		'default' => $language['default'],
		'order' => $language['order']
	    );
	}

	unset ( $languages, $language );

	return ($single) ? $return[0] : $return;
    }

    /**
     * Copiar traducciones
     *
     * @access 	public
     * @param 	array 	$from	Idioma de origen
     * @param 	array 	$to	Idioma de destino
     * @return 	void
     */
    private function _copy_lang_translations ( $from = NULL, $to = NULL )
    {
	$idiomas_traductor = $this
		->db
		->select ( '\'' . $to . '\' AS uID_idiomas, key, texto' )
		->from ( 'idiomas_traductor' )
		->where ( 'uID_idiomas', $from )
		->get ()
		->result_array ();

	if ( isset ( $idiomas_traductor ) && is_array ( $idiomas_traductor ) && !empty ( $idiomas_traductor ) )
	{
	    $this->db->insert_batch ( 'idiomas_traductor', $idiomas_traductor );
	}
    }

    /**
     * Copiar Blog
     *
     * @access 	public
     * @param 	array 	$from	Idioma de origen
     * @param 	array 	$to	Idioma de destino
     * @return 	void
     */
    private function _copy_blog_translations ( $from = NULL, $to = NULL )
    {

	$blog_categorias_info = $this
		->db
		->select ( 'uID_blog_categorias, \'' . $to . '\' AS uID_idiomas, texto' )
		->from ( 'blog_categorias_info' )
		->where ( 'uID_idiomas', $from )
		->get ()
		->result_array ();

	if ( isset ( $blog_categorias_info ) && is_array ( $blog_categorias_info ) && !empty ( $blog_categorias_info ) )
	{
	    $this->db->insert_batch ( 'blog_categorias_info', $blog_categorias_info );
	}

	$blog_info = $this
		->db
		->select ( '\'' . $to . '\' AS uID_idiomas, uID_blog, titulo, texto' )
		->from ( 'blog_info' )
		->where ( 'uID_idiomas', $from )
		->get ()
		->result_array ();

	if ( isset ( $blog_info ) && is_array ( $blog_info ) && !empty ( $blog_info ) )
	{
	    $this->db->insert_batch ( 'blog_info', $blog_info );
	}
    }

    /**
     * Copiar Galeria
     *
     * @access 	public
     * @param 	array 	$from	Idioma de origen
     * @param 	array 	$to	Idioma de destino
     * @return 	void
     */
    private function _copy_gallery_translations ( $from = NULL, $to = NULL )
    {

	$image_info = $this
		->db
		->select ( '\'' . $to . '\' AS uID_idiomas, uID_galeria_images, title, text' )
		->from ( 'galeria_images_info' )
		->where ( 'uID_idiomas', $from )
		->get ()
		->result_array ();

	if ( isset ( $image_info ) && is_array ( $image_info ) && !empty ( $image_info ) )
	{
	    $this->db->insert_batch ( 'galeria_images_info', $image_info );
	}
    }

    /**
     * Copiar Email templates
     *
     * @access 	public
     * @param 	array 	$from	Idioma de origen
     * @param 	array 	$to	Idioma de destino
     * @return 	void
     */
    private function _copy_emails_templates ( $from = NULL, $to = NULL )
    {

	$emails_templates = $this
		->db
		->select ( '\'' . $to . '\' AS uID_idiomas, uID_emails_tipos, subject, message' )
		->from ( 'emails_templates' )
		->where ( 'uID_idiomas', $from )
		->get ()
		->result_array ();

	if ( isset ( $emails_templates ) && is_array ( $emails_templates ) && !empty ( $emails_templates ) )
	{
	    $this->db->insert_batch ( 'emails_templates', $emails_templates );
	}
    }

    /**
     * Copiar Language Files of Codeigniter
     *
     * @access 	public
     * @param 	array 	$from	Idioma de origen
     * @param 	array 	$to	Idioma de destino
     * @return 	void
     */
    private function _copy_file_translations ( $from = NULL, $to = NULL )
    {

	return;
    }

}
