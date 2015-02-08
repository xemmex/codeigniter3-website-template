<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Emails_model extends CI_Model
{

    /**
     * Editar Template
     *
     * @access 	public
     * @param 	array 	$form	    Datos del formulario
     * @return 	bool		    Devuelve el array con los datos de la consulta
     */
    public function template_edit ( $form = array() )
    {
	foreach ( $form['templates'] as $language_id => $template )
	{
	    $update = array(
		'subject' => $template['subject'],
		'message' => $template['message']
	    );

	    $where = array(
		'uID_emails_tipos' => $form['uID'],
		'uID_idiomas' => $language_id
	    );

	    if ( !$this->db->update ( 'emails_templates', $update, $where ) )
	    {
		return FALSE;
	    }
	}

	return TRUE;
    }

    /**
     * Obtiene un Template
     *
     * @access 	public
     * @param 	int 	$uID	ID del Template
     * @return 	array		Devuelve el array con los datos de la consulta
     */
    public function template_get ( $uID = NULL )
    {
	$return = $this
		->db
		->select ( '
			    a.uID	AS id,
			    a.texto	AS text,
			    a.variables AS variables
			' )
		->from ( 'emails_tipos AS a' )
		->where ( 'a.uID', $uID )
		->get ()
		->row_array ();

	$return['id'] = $uID;

	$templates = $this
		->db
		->select ( '
	                    a.uID		    AS	id,
			    a.uID_idiomas	    AS	language_id,
			    a.uID_emails_tipos	    AS	email_type_id,
			    a.subject		    AS	subject,
			    a.message		    AS	message
			' )
		->from ( 'emails_templates a' )
		->join ( 'idiomas b', 'a.uID_idiomas = b.uID', 'inner' )
		->where ( 'a.uID_emails_tipos', $uID )
		->get ()
		->result_array ();

	foreach ( $templates as $template )
	{
	    $return['template'][$template['language_id']] = array(
		'id' => $template['id'],
		'subject' => $template['subject'],
		'message' => $template['message']
	    );
	}

	return $return;
    }

    /**
     * Obtenemos todos los log's
     *
     * @access 	public
     * @param 	array 	$filtros    Filtros a aplicar en la consulta
     * @param 	bool 	$count      Establecer a TRUE si solo desemas saber el nº de registros
     * @return 	array               Devuelve el array con los datos de la consulta
     */
    public function logs_get ( $filtros = array(), $count = FALSE )
    {
	$sql = $this
		->db
		->select ( '
	                    a.uID		    AS id,
                            b.texto                 AS email_type,
			    a.uID_emails_tipos	    AS email_type_id,
			    a.date                  AS date,
			    a.subject		    AS subject,
			    a.message		    AS message,
                            a.emails		    AS emails,
                            a.status		    AS status,
			    a.debug		    AS debug
			' )
		->from ( 'emails_logs a' )
		->join ( 'emails_tipos b', 'a.uID_emails_tipos = b.uID', 'join' )
		->order_by ( 'a.date', 'asc' );

	if ( isset ( $filtros['uID'] ) && is_numeric ( $filtros['uID'] ) )
	{
	    $sql->where ( 'a.uID', $filtros['uID'] );
	    $sql->limit ( 1 );
	}

	return ( $count ) ? $sql->count_all_results () : self::_logs_parse ( $sql->get ()->result_array (), isset ( $filtros['uID'] ) && is_numeric ( $filtros['uID'] ) ? TRUE : FALSE  );
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access 	private
     * @param 	array 	$logs       Array con todos los logs disponibles
     * @param 	array 	$return	    Variable de retorono de informacion
     * @return 	array		    Devuelve el array con los datos formateados
     */
    private function _logs_parse ( $logs = array(), $single = FALSE, $return = array() )
    {

	foreach ( $logs as $log )
	{
	    $return[] = array(
		'url_view' => backend_url ( array( 'emails', 'logs', $log['id'] ) ),
		'id' => $log['id'],
		'email_type' => tr ( '_GLOBAL' . $log['email_type'] ),
		'email_type_id' => $log['email_type_id'],
		'date' => $log['date'],
		'subject' => $log['subject'],
		'message' => $log['message'],
		'emails' => $log['emails'],
		'status' => $log['status'],
		'debug' => $log['debug']
	    );
	}

	return ($single) ? $return[0] : $return;
    }

    /**
     * Comprobar que el e-mail exista
     *
     * @access 	public
     * @param 	string 	$email	    Datos del formulario
     * @return 	bool		    Devuelve el array con los datos de la consulta
     */
    public function emails_exists ( $email = NULL )
    {
	$email = $this->db
		->select ( 'email' )
		->from ( 'emails' )
		->where ( 'email', $email )
		->get ()
		->num_rows ();

	return ( $email > 0 );
    }

    /**
     * Añdir e-mail
     *
     * @access 	public
     * @param 	array 	$form	    Datos del formulario
     * @return 	bool		    Devuelve el array con los datos de la consulta
     */
    public function emails_add ( $form = array() )
    {
	$add = array(
	    'uID_estados' => $form['status'],
	    'uID_emails_tipos' => implode ( ',', $form['emails_types'] ),
	    'nombre' => $form['name'],
	    'email' => $form['email'],
	    'oculto' => $form['cco']
	);

	return $this->db->insert ( 'emails', $add );
    }

    /**
     * Borrar e-mail
     *
     * @access 	public
     * @param 	array 	$delete     Filtros a aplicar en la consulta
     * @return 	array               Devuelve el array con los datos de la consulta
     */
    public function emails_delete ( $delete = array() )
    {
	return $this->db->delete ( 'emails', $delete );
    }

    /**
     * Obtenemos todas los emails disponibles
     *
     * @access 	public
     * @param 	array 	$filtros    Filtros a aplicar en la consulta
     * @param 	bool 	$count      Establecer a TRUE si solo desemas saber el nº de registros
     * @return 	array               Devuelve el array con los datos de la consulta
     */
    public function emails_get ( $filtros = array(), $count = FALSE )
    {
	$sql = $this
		->db
		->select ( '
	                    a.uID		    AS id,

			    a.uID_estados	    AS status_id,
                            a.uID_emails_tipos	    AS emails_types_id,
			    a.uID_emails_tipos	    AS emails_types,
			    a.nombre		    AS name,
			    a.email		    AS email,
			    a.oculto		    AS cco
			' )
		->from ( 'emails a' )
		->order_by ( 'a.uID', 'asc' );

	if ( isset ( $filtros['uID'] ) && is_numeric ( $filtros['uID'] ) )
	{
	    $sql->where ( 'a.uID', $filtros['uID'] );
	    $sql->limit ( 1 );
	}

	return ( $count ) ? $sql->count_all_results () : self::_emails_parse ( $sql->get ()->result_array () );
    }

    /**
     * Obtenemos todas los tipos de e-mails
     *
     * @access 	public
     * @param 	string 	$emails_types    Filtros a aplicar en la consulta
     * @return 	array                   Devuelve el array con los datos de la consulta
     */
    public function emails_get_types ( $emails_types = NULL )
    {
	$sql = $this
		->db
		->select ( 'a.uID AS id, a.texto AS text, a.variables' )
		->from ( 'emails_tipos a' )
		->order_by ( 'a.uID', 'asc' );

	if ( isset ( $emails_types ) )
	{
	    $sql->where ( "FIND_IN_SET( a.uID, '" . $emails_types . "') !=", 0 );
	}

	return self::_emails_get_types_parse ( $sql->get ()->result_array () );
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access 	private
     * @param 	array 	$emails_types   Array con todos los tipo de emails
     * @param 	array 	$return         Variable de retorono de informacion
     * @return 	array                   Devuelve el array con los datos formateados
     */
    private function _emails_get_types_parse ( $emails_types = array(), $single = FALSE, $return = array() )
    {
	foreach ( $emails_types as $type )
	{
	    $return[] = array(
		'url_view' => backend_url ( array( 'emails', 'templates', $type['id'] ) ),
		'url_edit' => backend_url ( array( 'emails', 'template-edit', $type['id'] ) ),
		'id' => $type['id'],
		'text' => tr ( '_GLOBAL' . $type['text'] ),
		'variables' => $type['variables']
	    );
	}

	return ($single) ? $return[0] : $return;
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access 	private
     * @param 	array 	$emails     Array con todos los emails disponibles
     * @param 	array 	$return	    Variable de retorono de informacion
     * @return 	array		    Devuelve el array con los datos formateados
     */
    private function _emails_parse ( $emails = array(), $single = FALSE, $return = array() )
    {

	foreach ( $emails as $email )
	{

	    $return[] = array(
		'url_delete' => backend_url ( array( 'emails', 'emails-delete', $email['id'] ) ),
		'url_edit' => backend_url ( array( 'emails', 'emails-edit', $email['id'] ) ),
		'id' => $email['id'],
		'status_id' => $email['status_id'],
		'emails_types_id' => $email['emails_types_id'],
		'emails_types' => self::emails_get_types ( $email['emails_types'] ),
		'name' => $email['name'],
		'email' => $email['email'],
		'cco' => $email['cco']
	    );
	}

	return ($single) ? $return[0] : $return;
    }

}
