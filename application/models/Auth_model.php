<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Auth_model extends CI_Model
{

    public $error;
    public $user;
    public $id;
    public $table;

    /**
     * Constructor de la clase
     *
     * @access    public
     */
    public function __construct ()
    {
	// $this->output->enable_profiler ( TRUE );
	$this->user = self::get_user_info ( $this->session->uID, 'a.uID' );
	$this->table = self::get_permission_table ( $this->user['permissions'] );
    }

    /**
     * Realizamos login al sistema
     *
     * @access    public
     * @param    array $form Array con los datos del formulario
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function login ( $form )
    {
	$user = self::get_user_info ( $form['email'] );

	if ( ( $user['password'] ) )
	{

	    if ( $user['status'] == 0 )
	    {
		$this->error = tr ( '_MODEL_AUTH_account_inactive_' );
		return FALSE;
	    }
	    else
	    {
		// Load Library
		$this->load->library ( 'encrypt' );

		if ( self::_decode_password ( $user['password'] ) == $form['password'] )
		{
		    // Unlock Account
		    self::unlock_account ( $user['uID'] );

		    // Log User Login
		    self::_log ( 'login', $user['uID'] );

		    // Set Session Data
		    self::_set_session ( $user, $form['remember'] );

		    return TRUE;
		}
		else
		{
		    $this->error = tr ( '_MODEL_AUTH_password_incorrect_' );
		    return FALSE;
		}
	    }
	}
	else
	{
	    $this->error = tr ( '_MODEL_AUTH_email_do_not_exist_' );
	    return FALSE;
	}
    }

    /**
     * Actualiza la ultima actividad del usuario en el backend
     *
     * @access    public
     * @return    void
     */
    public function update_last_activity ()
    {
	$this->session->set_userdata ( 'last_activity', now () );
    }

    /**
     * Comprobamos si el usuario actual es offline
     *
     * @access    public
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function offline ()
    {
	// Check if Locked option is activated
	if ( ( bool ) $this->settings_model->system['_user_locked_status_'] === TRUE )
	{
	    // Check if user is locked
	    if ( ( bool ) user ( 'locked_status' ) === TRUE )
	    {
		return TRUE;
	    }
	    else
	    if ( time () > strtotime ( '+' . $this->settings_model->system['_user_locked_timeout_'] . ' minutes', $this->session->last_activity ) )
	    {
		return self::lock_account ( $this->session->uID );
	    }
	    else
	    {
		return FALSE;
	    }
	}
	else
	{
	    return FALSE;
	}
    }

    /**
     * Bloqueamos la cuenta
     *
     * @access	public
     * @param	int	$uID	ID del usuario
     * @return	bool		Devuelve TRUE o FALSE
     */
    public function lock_account ( $uID )
    {
	$data = array(
	    'locked_status' => 1
	);

	$where = array(
	    'uID' => $uID
	);

	return $this->db->update ( 'usuarios', $data, $where );
    }

    /**
     * Desbloqueamos la cuenta
     *
     * @access	public
     * @param	int	$uID	ID del usuario
     * @return	bool		Devuelve TRUE o FALSE
     */
    public function unlock_account ( $uID )
    {
	$data = array(
	    'locked_status' => 0
	);

	$where = array(
	    'uID' => $uID
	);

	return $this->db->update ( 'usuarios', $data, $where );
    }

    /**
     * Creamos un nuevo usuario con perfil suministrado
     *
     * @access	public
     * @param	array	$form		Informacion de registro
     * @param	int	$uID_permisos	uID del permisos a establecer
     * @param	int	$uID_estados	uID del estado a establecer
     * @return	bool			Devuelve TRUE o FALSE
     */
    public function create_account ( $form = array(), $uID_permisos = 1, $uID_estados = 1 )
    {
	$user = self::get_user_info ( $form['email'] );

	if ( isset ( $user['email'] ) && $user['email'] == $form['email'] )
	{
	    $this->error = tr ( '_MODEL_AUTH_email_in_use_' );
	    return FALSE;
	}
	else
	{
	    $data = array(
		'uID_idiomas' => $this->settings_model->language['uID'], 'uID_permisos' => $uID_permisos, 'uID_estados' => $uID_estados, 'register_status' => 1, 'register_token' => self::create_token (), 'nombre' => $form['name'], 'apellido' => $form['lastname'], 'email' => $form['email'], 'password' => self::_encode_password ( $form['password'] )
	    );

	    if ( $this->db->insert ( 'usuarios', $data ) )
	    {
		// Log User Login
		$this->id = $this->db->insert_id ();
		self::_log ( 'register', $this->id );

		return TRUE;
	    }
	    else
	    {
		return FALSE;
	    }
	}
    }

    /**
     * Creamos un nuevo usuario con perfil suministrado
     *
     * @access    public
     * @param    array $uID_permisos uID del permisos a establecer
     * @param    array $form Informacion de registro
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function register ( $uID_permisos, $form )
    {
	$user = self::get_user_info ( $form['email'] );

	if ( isset ( $user['email'] ) && $user['email'] == $form['email'] )
	{
	    $this->error = tr ( '_MODEL_AUTH_email_in_use_' );
	    return FALSE;
	}
	else
	{
	    $register_token = self::create_token ();

	    $data = array(
		'uID_idiomas' => $this->settings_model->language['uID'], 'uID_permisos' => $uID_permisos, 'uID_estados' => 0, 'register_status' => 0, 'register_token' => $register_token, 'nombre' => $form['name'], 'apellido' => $form['lastname'], 'email' => $form['email'], 'password' => self::_encode_password ( $form['password'] )
	    );

	    if ( $this->db->insert ( 'usuarios', $data ) )
	    {
		// Log User Login
		self::_log ( 'register', $this->db->insert_id () );

		return $register_token;
	    }
	    else
	    {
		return FALSE;
	    }
	}
    }

    /**
     * Activamos la cuenta
     *
     * @access    public
     * @param    array $register_token Token del registro
     * @return    bool                        Devuelve TRUE o FALSE
     */
    public function activate_account ( $register_token )
    {
	$user = self::get_user_info ( $register_token, 'a.register_token' );

	if ( isset ( $user['register_token'] ) )
	{
	    $data = array(
		'register_status' => 1, 'uID_estados' => 1
	    );

	    $where = array(
		'register_token' => $register_token, 'register_status' => 0, 'uID_estados' => 0
	    );

	    if ( $this->db->update ( 'usuarios', $data, $where ) )
	    {
		// Log User Login
		self::_log ( 'register_token', $user['uID'] );

		return TRUE;
	    }
	    else
	    {
		return FALSE;
	    }
	}
    }

    /**
     * Realizamos login al sistema desde un cookie
     *
     * @access    public
     * @param    array $form Array con datos del formulario locked
     * @return    bool        Devuelve TRUE o FALSE
     */
    public function login_from_locked ( $form = array() )
    {

	$user = self::get_user_info ( $this->session->uID, 'a.uID' );

	if ( self::_decode_password ( $user['password'] ) == $form['password'] )
	{
	    // Unlock Account
	    self::unlock_account ( $this->session->uID );

	    // Log User Login
	    self::_log ( 'login_locked', $user['uID'] );

	    // Set Session Data
	    self::_set_session ( $user, TRUE );

	    return TRUE;
	}

	$this->error = tr ( '_MODEL_AUTH_password_incorrect_' );
	return FALSE;
    }

    /**
     * Realizamos login al sistema desde un cookie
     *
     * @access    public
     * @param    array $remember_token Token del cookie
     * @return    bool                Devuelve TRUE o FALSE
     */
    public function login_from_cookie ( $remember_token )
    {

	$user = self::get_user_info ( $remember_token, 'a.remember_token' );

	if ( isset ( $user['remember_token'] ) )
	{
	    // Unlock Account
	    self::unlock_account ( $user['uID'] );

	    // Log User Login
	    self::_log ( 'login_remember', $user['uID'] );

	    // Set Session Data
	    self::_set_session ( $user, TRUE );

	    return TRUE;
	}
	else
	{
	    show_404 ();
	}
    }

    /**
     * Comprobamos si el token recibido es valida
     *
     * @access    public
     * @param    array $register_token Token del registro
     * @return    bool                        Devuelve TRUE o FALSE
     */
    public function is_register_token_valid ( $register_token )
    {

	$user = self::get_user_info ( $register_token, 'a.register_token' );

	if ( isset ( $user['register_token'] ) )
	{

	    if ( $user['status'] == 1 )
	    {
		$this->error = tr ( '_MODEL_AUTH_user_already_activated_' );
		return FALSE;
	    }
	    else if ( !isset ( $user['register_status'] ) || $user['register_status'] == 1 )
	    {
		$this->error = tr ( '_MODEL_AUTH_token_used_or_invalid_status_' );
		return FALSE;
	    }
	    else
	    {
		return TRUE;
	    }
	}
	else
	{
	    $this->error = tr ( '_MODEL_AUTH_token_do_not_exist_' );
	    return FALSE;
	}

	return FALSE;
    }

    /**
     * Comprobamos si el token recibido es valida
     *
     * @access    public
     * @param    array $forgot_token Token de la contraseña
     * @return    bool                        Devuelve TRUE o FALSE
     */
    public function is_forgot_token_valid ( $forgot_token )
    {
	$user = self::get_user_info ( $forgot_token, 'a.forgot_token' );

	if ( isset ( $user['forgot_token'] ) )
	{

	    if ( $user['status'] == 0 )
	    {
		$this->error = tr ( '_MODEL_AUTH_account_inactive_' );
		return FALSE;
	    }
	    else if ( !isset ( $user['forgot_status'] ) || $user['forgot_status'] == 1 )
	    {
		$this->error = tr ( '_MODEL_AUTH_token_used_or_invalid_status_' );
		return FALSE;
	    }
	    else if ( strtotime ( $user['forgot_fecha'] ) < strtotime ( '-1 days' ) )
	    {
		$this->error = tr ( '_MODEL_AUTH_token_lapsed_' );
		return FALSE;
	    }
	    else
	    {
		return TRUE;
	    }
	}
	else
	{
	    $this->error = tr ( '_MODEL_AUTH_token_do_not_exist_' );
	    return FALSE;
	}

	return FALSE;
    }

    /**
     * Cramos el token para la recuperacion de contraseña
     *
     * @access    public
     * @param    array $email Email del usuario
     * @param    array $email_repeat Repeticion del e-mail
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function create_forgot_token ( $email, $email_repeat )
    {
	if ( $email != $email_repeat )
	{
	    $this->error = tr ( '_MODEL_AUTH_email_not_equals_' );
	    return FALSE;
	}

	$user = self::get_user_info ( $email );

	if ( $user['email'] )
	{

	    if ( $user['status'] == 0 )
	    {
		$this->error = tr ( '_MODEL_AUTH_account_inactive_' );
		return FALSE;
	    }
	    else
	    {

		$forgot_token = self::create_token ();

		$data = array(
		    'forgot_token' => $forgot_token, 'forgot_fecha' => date ( 'Y-m-d H:i:s' ), 'forgot_status' => 0
		);

		$where = array(
		    'email' => $email
		);

		if ( $this->db->update ( 'usuarios', $data, $where ) )
		{
		    // Log User Login
		    self::_log ( 'forgot_token', $user['uID'] );

		    return $forgot_token;
		}
		else
		{
		    return FALSE;
		}
	    }
	}
	else
	{
	    $this->error = tr ( '_MODEL_AUTH_email_do_not_exist_' );
	    return FALSE;
	}
    }

    /**
     * Cramos el token del cookie para el auto-login
     *
     * @access    public
     * @param    array $uID uID del usuario
     * @param    array $remeber_token Token del cookie
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function create_remember_token ( $uID, $remeber_token )
    {
	$data = array(
	    'remember_token' => $remeber_token
	);

	$where = array(
	    'uID' => $uID
	);

	return $this->db->update ( 'usuarios', $data, $where );
    }

    /**
     * Modifica el estado del perfil
     *
     * @access    public
     * @param    int $uID_estados ID del estado a guardas
     * @param    int $uID_usuarios ID del usuario a modificar
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function update_status ( $uID_estados = NULL, $uID_usuarios = NULL )
    {

	if ( is_profile ( '_admin_' ) === FALSE )
	{
	    if ( $uID_estados >= user ( 'permissions' ) )
	    {
		return FALSE;
	    }
	}

	$data = array(
	    'uID_estados' => $uID_estados
	);

	$where = array(
	    'uID' => ( isset ( $uID_usuarios ) ) ? $uID_usuarios : $this->session->uID
	);

	if ( !$this->db->update ( 'usuarios', $data, $where ) )
	{
	    $this->error = tr ( '_MODEL_AUTH_error_update_db_' );
	    return FALSE;
	}
	else
	{
	    // Log User Login
	    self::_log ( 'mod_status', $this->session->uID );

	    return TRUE;
	}
    }

    /**
     * Modifica el estado del perfil
     *
     * @access    public
     * @param    int $uID_permisos ID del estado a guardas
     * @param    int $uID_usuarios ID del usuario a modificar
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function update_permission ( $uID_permisos = NULL, $uID_usuarios = NULL )
    {
	$data = array(
	    'uID_permisos' => $uID_permisos
	);

	$where = array(
	    'uID' => ( isset ( $uID_usuarios ) ) ? $uID_usuarios : $this->session->uID
	);

	if ( !$this->db->update ( 'usuarios', $data, $where ) )
	{
	    $this->error = tr ( '_MODEL_AUTH_error_update_db_' );
	    return FALSE;
	}
	else
	{
	    // Log User Login
	    self::_log ( 'mod_permissions', $this->session->uID );

	    return TRUE;
	}
    }

    /**
     * Modifica los datos del perfil basicos
     *
     * @access    public
     * @param    array $form Array con nuevos datos del perfil
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function update_profile ( $form, $uID = NULL )
    {
	$data = array(
	    'nombre' => $form['name'], 'apellido' => $form['lastname'], 'email' => $form['email'], 'uID_idiomas' => $form['language']
	);

	$where = array(
	    'uID' => ( isset ( $uID ) ) ? $uID : $this->session->uID
	);

	if ( !$this->db->update ( 'usuarios', $data, $where ) )
	{
	    $this->error = tr ( '_MODEL_AUTH_error_update_db_' );
	    return FALSE;
	}
	else
	{
	    // Log User Login
	    self::_log ( 'mod_profile', $this->session->uID );

	    self::_update_session ( $form );

	    return TRUE;
	}
    }

    /**
     * Modifica los datos del perfil no obligatorios
     *
     * @access    public
     * @param    array $form Array con nuevos datos del perfil
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function update_profile_extra_info ( $form, $uID = NULL )
    {
	$data = array(
	    'uID_usuarios' => ( isset ( $uID ) ) ? $uID : $this->session->uID, 'cargo' => $form['cargo'], 'vat' => $form['vat'], 'phone' => $form['phone'], 'mobile_phone' => $form['mobile_phone'], 'fax' => $form['mobile_phone'], 'address' => $form['address'], 'description' => $form['description']
	);

	// Avatar
	if ( isset ( $form['avatar'] ) && !empty ( $form['avatar'] ) )
	{
	    $data['avatar'] = $form['avatar'];
	}

	$where = array(
	    'uID_usuarios' => ( isset ( $uID ) ) ? $uID : $this->session->uID
	);

	$user_info = $this->db->get_where ( 'usuarios_info', $where );

	if ( $user_info->num_rows () > 0 )
	{
	    $result = $this->db->update ( 'usuarios_info', $data, $where );
	}
	else
	{
	    $result = $this->db->insert ( 'usuarios_info', $data );
	}

	if ( !$result )
	{
	    $this->error = tr ( '_MODEL_AUTH_error_update_db_' );
	    return FALSE;
	}
	else
	{
	    // Log User Login
	    self::_log ( 'mod_profile_info', ( isset ( $uID ) ) ? $uID : $this->session->uID  );

	    self::_update_session ( $form );

	    return TRUE;
	}
    }

    /**
     * Cambia la contraseña del usuario actual
     *
     * @access    public
     * @param    array $form Array con los datos del formulario
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function change_password ( $form, $uID = NULL )
    {

	if ( $form['password'] != $form['password_repeat'] )
	{
	    return FALSE;
	}

	$data = array(
	    'password' => self::_encode_password ( $form['password'] )
	);

	$where = array(
	    'uID' => ( isset ( $uID ) ) ? $uID : $this->session->uID
	);

	if ( !$this->db->update ( 'usuarios', $data, $where ) )
	{
	    $this->error = tr ( '_MODEL_AUTH_error_update_db_' );
	    return FALSE;
	}
	else
	{
	    return TRUE;
	}
    }

    /**
     * Cambia la contraseña del usuario actual
     *
     * @access    public
     * @param    array $form Array con los datos del formulario
     * @return    bool            Devuelve TRUE o FALSE
     */
    public function change_password_from_profile ( $form, $uID = NULL )
    {

	if ( $form['new_password'] != $form['new_password_repeat'] )
	{
	    $this->error = tr ( '_MODEL_AUTH_password_mismatch_' );
	    return FALSE;
	}

	$user = self::get_user_info ( ( isset ( $uID ) ) ? $uID : $this->session->uID, 'a.uID' );

	if ( self::_decode_password ( $user['password'] ) != $form['old_password'] )
	{
	    $this->error = tr ( '_MODEL_AUTH_old_password_incorrect_' );
	    return FALSE;
	}

	$data = array(
	    'password' => self::_encode_password ( $form['new_password'] )
	);

	$where = array(
	    'uID' => ( isset ( $uID ) ) ? $uID : $this->session->uID
	);

	if ( !$this->db->update ( 'usuarios', $data, $where ) )
	{
	    $this->error = tr ( '_MODEL_AUTH_error_update_db_' );
	    return FALSE;
	}
	else
	{

	    // Log User Login
	    self::_log ( 'mod_password', $user['uID'] );

	    return TRUE;
	}
    }

    /**
     * Cambia la contraseña del usuario actual
     *
     * @access    public
     * @param    string $token Token del usuario
     * @param    string $password Password a cambiar
     * @return    bool                Devuelve TRUE o FALSE
     */
    public function change_password_from_token ( $token, $password )
    {
	$data = array(
	    'password' => self::_encode_password ( $password ), 'forgot_status' => 1
	);

	$where = array(
	    'forgot_token' => $token, 'forgot_status' => 0
	);

	if ( $this->db->update ( 'usuarios', $data, $where ) )
	{
	    // Get User Infor
	    $user = self::get_user_info ( $token, 'a.forgot_token' );

	    // Log User Login
	    self::_log ( 'mod_password', $user['uID'] );

	    return TRUE;
	}
	else
	{
	    return FALSE;
	}
    }

    /**
     * Create Token
     *
     * @access    public
     * @param    int $length Logintud del TOKEN
     * @return    bool                Devuelve TRUE o FALSE
     */
    public function create_token ( $length = 8 )
    {
	return substr ( sha1 ( uniqid ( rand (), TRUE ) ), rand ( 1, 32 ), $length );
    }

    /**
     * Log access in DDBB
     *
     * @access    public
     * @param    string $tipo Campo a Actualizar
     * @param    int $uID_usuarios uID del usuario a actualizar
     * @return    bool                    Devuelve TRUE o FALSE
     */
    public function _log ( $tipo = 'login', $uID_usuarios )
    {

	$this->db->from ( 'usuarios_logs' )
		->where ( 'uID_usuarios', $uID_usuarios );

	if ( $this->db->count_all_results () == 0 )
	{
	    $data = array(
		'fecha_' . $tipo => date ( 'Y-m-d H:i:s' ), 'uID_usuarios' => $uID_usuarios, 'uID_usuarios_action' => $this->session->uID
	    );

	    return $this->db->insert ( 'usuarios_logs', $data );
	}
	else
	{
	    $data = array(
		'fecha_' . $tipo => date ( 'Y-m-d H:i:s' ), 'uID_usuarios_action' => $this->session->uID
	    );

	    $where = array(
		'uID_usuarios' => $uID_usuarios
	    );

	    return $this->db->update ( 'usuarios_logs', $data, $where );
	}
    }

    /**
     * Encriptar contraseña
     *
     * @access    public
     * @param    string $password Password a encriptar
     * @return    bool                Devuelve TRUE o FALSE
     */
    public function _encode_password ( $password )
    {
	$this->load->library ( 'encrypt' );

	return $this->encrypt->encode ( $password );
    }

    /**
     * Desencriptar contraseña
     *
     * @access    public
     * @param    string $password Password a desencriptar
     * @return    bool                Devuelve TRUE o FALSE
     */
    public function _decode_password ( $password )
    {
	$this->load->library ( 'encrypt' );

	return $this->encrypt->decode ( $password );
    }

    /**
     * Obtenemos la tabla de permisos
     *
     * @access    public
     * @param    int $uID_permisos ID de permisos
     * @return    array                       Array con los datos de la consulta
     */
    public function get_permission_table ( $uID_permisos = 1 )
    {

	return $this->db->select ( 'a.uID_estados AS status_id, a.uID_permisos AS permission_id, a.Controller' )
			->from ( 'usuarios_permisos_table a' )
			->where ( 'a.uID_estados', 1 )
			->where ( 'a.uID_permisos', $uID_permisos )
			->get ()
			->result_array ();
    }

    /**
     * Obtenemos informacion de un usuario
     *
     * @access    public
     * @param    mixed $value Valor a comprobar
     * @param    string $column Columna a buscar el valor a comprobar
     * @return    array               Array con los datos de la consulta
     */
    public function get_user_info ( $value, $column = 'a.email' )
    {
	return $this->db->select ( '
                        a.uID,
                        a.uID_idiomas AS language,
                        a.uID_permisos AS permissions,
                        a.uID_estados AS status,
                        a.nombre AS name,
                        a.apellido AS lastname,
                        a.email AS email,
                        a.password AS password,
                        a.remember_token,
                        a.register_token,
                        a.register_status,

			a.locked_status,

                        a.forgot_token,
                        a.forgot_fecha,
                        a.forgot_status,

                        b.fecha_login,
                        b.fecha_mod_password,
                        b.fecha_mod_profile,
			b.fecha_register,

                        a.forgot_fecha,
                        a.forgot_status,
                        c.vat,
                        c.phone,
                        c.mobile_phone,
                        c.fax,
                        c.address,
                        c.description,
                        c.avatar,
                        c.cargo,

			d.texto AS permission_text,
                        d.class AS permission_class,

			e.texto AS status_text,

			f.text AS language_text
		    ', FALSE )
			->from ( 'usuarios a' )
			->join ( 'usuarios_logs b', 'a.uID = b.uID_usuarios', 'left' )
			->join ( 'usuarios_info c', 'a.uID = c.uID_usuarios', 'left' )
			->join ( 'usuarios_permisos d', 'a.uID_permisos = d.uID', 'inner' )
			->join ( 'estados e', 'a.uID_estados = e.uID', 'inner' )
			->join ( 'idiomas f', 'a.uID_idiomas = f.uID', 'inner' )
			->where ( $column, $value )
			->limit ( 1 )
			->get ()
			->row_array ();
    }

    /**
     * Actualiza la session actual
     *
     * @access    private
     * @param    array $form Array con los datos del formulario
     * @return    bool            Devuelve TRUE o FALSE
     */
    private function _update_session ( $form )
    {
	return $this->session->set_userdata ( $form );
    }

    /**
     * Establece una nueva session con los datos del usuario actual
     * Tambien almacena en este model los datos del usuario actual
     *
     * @access    private
     * @param    array $user Array con la informacion de usuario
     * @param    bool $remember Recuerda el inicio se session si se cierra el navegador
     * @return    bool                Devuelve TRUE o FALSE
     */
    private function _set_session ( $user, $remember = FALSE )
    {

	$session_data = array(
	    'is_logged_in' => TRUE,
	    'uID' => $user['uID'],
	    'last_activity' => now ()
	);

	if ( ( bool ) $remember === TRUE )
	{
	    $remember_token = $user['uID'] . self::create_token ();

	    if ( self::create_remember_token ( $user['uID'], $remember_token ) )
	    {
		set_cookie ( array(
		    'name' => 'remember_id', 'value' => $$user['uID'], 'expire' => 60 * 60 * 24 * 365 * 2
		) );

		set_cookie ( array(
		    'name' => 'remember_token', 'value' => $remember_token, 'expire' => 60 * 60 * 24 * 365 * 2
		) );
	    }
	}
	$this->user = $user;
	$this->session->set_userdata ( $session_data );
    }

}
