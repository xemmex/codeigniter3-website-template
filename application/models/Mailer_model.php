<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Mailer_model extends CI_Model
{

    public $addresses = array();
    public $template = array();

    /**
     * Constructor de la clase
     *
     * @access 	public
     */
    public function __construct ()
    {
	self::_get_config ();
    }

    /**
     * Enviamos el E-mail
     *
     * @access 	public
     * @param 	int	$uID_emails_tipos	ID del template
     * @param 	array	$data			Array con los datos a parsear
     * @param 	array	$addresses		Extra E-mail address to send
     * @return 	bool				Resultado del envio
     */
    public function send ( $uID_emails_tipos = NULL, $data = array(), $addresses = array() )
    {
	$this->template = self::_get_template ( $uID_emails_tipos, $data );
	$this->addresses = array_merge ( (is_array ( $addresses ) && !empty ( $addresses )) ? array( $addresses ) : array(), self::_get_addresses ( $uID_emails_tipos ) );

	return self::_send ();
    }

    /**
     * Obentemos el Template a enviar
     *
     * @access 	public
     * @param 	int		$uID_emails_tipos	ID del template
     * @param 	array	$data				Array con los datos a parsear
     * @return 	array 						Devuelve el array con los datos de la consulta
     */
    private function _get_template ( $uID_emails_tipos = NULL, $data = array() )
    {
	$template = $this->db->select ( 'a.uID_emails_tipos, a.subject, a.message' )
		->from ( 'emails_templates  a' )
		->where ( 'a.uID_idiomas', $this->settings_model->language['uID'] )
		->where ( 'a.uID_emails_tipos', $uID_emails_tipos )
		->get ()
		->row_array ();

	if ( isset ( $data ) && !empty ( $data ) )
	{
	    return self::_parse_template ( $template, $data );
	}
	else
	{
	    return $template;
	}
    }

    /**
     * Obentemos las direcciones de correo a enviar
     *
     * @access 	public
     * @param 	int		$uID_emails_tipos	ID del template
     * @return 	array 						Devuelve el array con las direcciones de correo
     */
    private function _get_addresses ( $uID_emails_tipos = NULL )
    {
	return $this->db->select ( 'a.nombre, a.email, a.oculto' )
			->from ( 'emails  a' )
			->where ( 'a.uID_estados', 1 )
			->where ( 'FIND_IN_SET( \'' . $uID_emails_tipos . '\', a.uID_emails_tipos )' )
			->get ()
			->result_array ();
    }

    /**
     * Creamos un registro en el Log por correo enviado
     *
     * @access 	private
     * @param 	string      $status             Estado del envio de e-mails
     * @param 	int         $uID_emails_tipos   ID del template
     * @param 	string      $subject            Asunto del mensaje
     * @param 	string      $message            Cuerpo del mensaje
     * @param 	string      $emails             Dirección de e-mail de destinatario
     * @param 	string      $debug              String con el debug del envio
     * @return 	void
     */
    private function _set_log ( $status = '', $uID_emails_tipos = NULL, $subject = '', $message = '', $emails = array(), $debug = NULL )
    {

	$insert = array(
	    'uID_emails_tipos' => $uID_emails_tipos,
	    'date' => date ( 'Y-m-d H:i:s' ),
	    'subject' => $subject,
	    'message' => $message,
	    'emails' => $emails,
	    'status' => $status,
	    'debug' => $debug
	);

	$this->db->insert ( 'emails_logs', $insert );
    }

    /**
     * Maqueta el Template con la informacion del formulario
     *
     * @access 	private
     * @param 	array	$template   ID del template
     * @param 	array	$data	    Array con la informacion a parsear
     * @return 	array		    Devuelve un array con los datos parseados
     */
    private function _parse_template ( $template = array(), $data = array() )
    {

	// Replace Path
	$template['message'] = str_replace ( 'src="/', 'src="' . base_url (), $template['message'] );

	// Replace Fixed Variables
	$template['message'] = str_replace ( array( '{subject}', '{copyright}', '{date}' ), array( $template['subject'], $this->settings_model->system['_system_copyright_'], date ( 'Y-m-d' ) ), $template['message'] );

	// Replace Body
	foreach ( $data as $key => $value )
	{
	    $template['message'] = str_replace ( '{' . $key . '}', $value, $template['message'] );
	}

	unset ( $data );

	// Return Array
	return array(
	    'uID_emails_tipos' => $template['uID_emails_tipos'],
	    'subject' => $template['subject'],
	    'message' => $template['message']
	);
    }

    /**
     * Obtenemos la configuracion del E-Mail
     *
     * @access 	private
     * @return 	void
     */
    private function _get_config ()
    {

	// Config Email system
	switch ( $this->settings_model->system['_mail_protocol_'] )
	{
	    case 'mail' :
	    default :
		$config = Array(
		    'protocol' => 'mail',
		    'mailtype' => $this->settings_model->system['_mail_mailtype_'],
		    'charset' => $this->settings_model->system['_mail_charset_'],
		    'validate' => TRUE
		);
		break;
	    case 'smtp' :

		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => $this->settings_model->system['_mail_smtp_host_'],
		    'smtp_port' => $this->settings_model->system['_mail_smtp_port_'],
		    'smtp_user' => $this->settings_model->system['_mail_smtp_user_'],
		    'smtp_pass' => $this->settings_model->system['_mail_smtp_pass_'],
		    'mailtype' => $this->settings_model->system['_mail_mailtype_'],
		    'charset' => $this->settings_model->system['_mail_charset_'],
		    'validate' => TRUE
		);
		break;

	    case 'sendmail' :
		$config = Array(
		    'protocol' => 'sendmail',
		    'smtp_host' => $this->settings_model->system['_mail_smtp_host_'],
		    'smtp_port' => $this->settings_model->system['_mail_smtp_port_'],
		    'smtp_user' => $this->settings_model->system['_mail_smtp_user_'],
		    'smtp_pass' => $this->settings_model->system['_mail_smtp_pass_'],
		    'mailtype' => $this->settings_model->system['_mail_mailtype_'],
		    'mailpath' => $this->settings_model->system['_mail_mailpath_'],
		    'charset' => $this->settings_model->system['_mail_charset_'],
		    'validate' => TRUE
		);
		break;
	}

	// Library
	$this->load->library ( 'email', $config );
	$this->email->set_newline ( "\r\n" );
    }

    /**
     * Envia el e-mail
     *
     * @access 	private
     * @return 	void
     */
    private function _send ()
    {

	// Clear Old E-mail Instance
	$this->email->clear ();

	// From E-mail
	$this->email->from ( $this->settings_model->system['_mail_from_email_'], $this->settings_model->system['_mail_from_name_'] );

	// Set e-mail addresses
	foreach ( $this->addresses as $info )
	{
	    if ( isset ( $info['email'] ) && isset ( $info['oculto'] ) && ( bool ) $info['oculto'] === TRUE )
	    {
		$this->email->bcc ( $info['email'] );
	    }
	    else
	    if ( isset ( $info['email'] ) )
	    {
		$info['oculto'] = false;
		$this->email->to ( $info['email'] );
	    }
	}

	// Set Subject an Message
	$this->email->subject ( $this->template['subject'] );
	$this->email->message ( $this->template['message'] );

	// Send E-mail
	if ( $this->email->send () )
	{
	    self::_set_log ( 'OK', $this->template['uID_emails_tipos'], $this->template['subject'], $this->template['message'], serialize ( $this->addresses ), NULL );

	    return TRUE;
	}
	else
	{
	    self::_set_log ( 'ERROR', $this->template['uID_emails_tipos'], $this->template['subject'], $this->template['message'], serialize ( $this->addresses ), $this->email->print_debugger () );

	    return FALSE;
	}
    }

}
