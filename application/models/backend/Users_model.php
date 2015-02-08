<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Users_model extends CI_Model
{

    /**
     * Borrar usuario
     *
     * @access 	public
     * @param 	array 	$delete     Filtros a aplicar en la consulta
     * @return 	array               Devuelve el array con los datos de la consulta
     */
    public function delete ( $delete = array() )
    {
	return $this->db->delete ( 'usuarios', $delete );
    }

    /**
     * Obentemos un campo actualizado del perfil del usuario
     *
     * @access 	public
     * @param 	array 	$uID        ID del usuario
     * @param 	bool 	$type       Nombre del campo a obtener
     * @return 	mixed               Valor del campo devuelto
     */
    public function get_user_var ( $uID = NULL, $type = 'c.avatar' )
    {
	$user = $this->db
		->select ( $type . ' AS var' )
		->from ( 'usuarios a' )
		->join ( 'usuarios_logs b', 'a.uID = b.uID_usuarios', 'left' )
		->join ( 'usuarios_info c', 'a.uID = c.uID_usuarios', 'left' )
		->join ( 'usuarios_permisos d', 'a.uID_permisos = d.uID', 'inner' )
		->join ( 'estados e', 'a.uID_estados = e.uID', 'inner' )
		->join ( 'idiomas f', 'a.uID_idiomas = f.uID', 'inner' )
		->where ( 'a.uID ', $uID )
		->limit ( 1 )
		->get ()
		->row_array ();

	return $user['var'];
    }

    /**
     * Obtenemos todas los usuarios del sistema
     *
     * @access 	public
     * @param 	array 	$filtros    Filtros a aplicar en la consulta
     * @param 	bool 	$count      Establecer a TRUE si solo desemas saber el nº de registros
     * @return 	array               Devuelve el array con los datos de la consulta
     */
    public function get_users ( $filtros = array(), $count = FALSE )
    {
	$sql = $this
		->db
		->select ( '
	                    a.uID		    AS id,

			    a.uID_idiomas	    AS language,
			    a.uID_permisos	    AS permission_id,
			    a.uID_estados	    AS status_id,

			    a.nombre		    AS name,
			    a.apellido		    AS lastname,
			    a.email		    AS email,
			    a.password		    AS password,

			    a.remember_token,
			    a.register_token,
			    a.register_status,

			    a.forgot_token,
			    a.forgot_fecha,
			    a.forgot_status,

			    b.fecha_login	    AS date_last_login,
			    b.fecha_mod_password    AS date_last_mod_password,
			    b.fecha_mod_profile	    AS date_last_mod_profile,
			    b.fecha_register	    AS date_register,

			    a.forgot_fecha,
			    a.forgot_status,

                            c.cargo,
			    c.vat,
			    c.phone,
			    c.mobile_phone,
			    c.fax,
			    c.address,
			    c.description,
			    c.avatar,

			    d.texto		    AS permission,
                            d.class		    AS permission_class,

			    e.texto		    AS status,

			    f.text		    AS language_id
			' )
		->from ( 'usuarios a' )
		->join ( 'usuarios_logs b', 'a.uID = b.uID_usuarios', 'left' )
		->join ( 'usuarios_info c', 'a.uID = c.uID_usuarios', 'left' )
		->join ( 'usuarios_permisos d', 'a.uID_permisos = d.uID', 'inner' )
		->join ( 'estados e', 'a.uID_estados = e.uID', 'inner' )
		->join ( 'idiomas f', 'a.uID_idiomas = f.uID', 'inner' )
		->where ( 'a.uID != ', user ( 'uID' ) )
		->order_by ( 'a.uID', 'asc' );

	if ( isset ( $filtros['uID'] ) && is_numeric ( $filtros['uID'] ) )
	{
	    $sql->where ( 'a.uID', $filtros['uID'] );
	    $sql->limit ( 1 );
	}

	if ( is_profile ( '_admin_' ) === FALSE )
	{
	    $sql->where ( 'a.uID_permisos <', user ( 'permissions' ) );
	}

	return ( $count ) ? $sql->count_all_results () : self::_parse_users ( $sql->get ()->result_array (), (isset ( $filtros['uID'] )) ? TRUE : FALSE  );
    }

    /**
     * Formateamos los resultados para mejor visibilidad
     *
     * @access 	private
     * @param 	array 	$users	    Array con todos los usuarios
     * @param 	bool 	$single	    Indica si debe solo devolver la primera fila
     * @param 	array 	$return	    Variable de retorono de informacion
     * @return 	array		    Devuelve el array con los datos formateados
     */
    private function _parse_users ( $users = array(), $single = FALSE, $return = array() )
    {

	foreach ( $users as $user )
	{
	    $return[] = array(
		'id' => $user['id'],
		//
		'url_delete' => backend_url ( array( 'users', 'delete', $user['id'] ) ),
		'url_edit' => backend_url ( array( 'users', 'edit', $user['id'] ) ),
		'url_change_password' => backend_url ( array( 'users', 'change-password', $user['id'] ) ),
		//
		'remember_token' => $user['remember_token'],
		//
		'register_token' => $user['register_token'],
		'register_status' => $user['register_status'],
		//
		'forgot_token' => $user['forgot_token'],
		'forgot_fecha' => $user['forgot_fecha'],
		'forgot_status' => $user['forgot_status'],
		//
		'date_last_login' => date ( 'd-m-Y', strtotime ( $user['date_last_login'] ) ),
		'date_last_mod_password' => date ( 'd-m-Y', strtotime ( $user['date_last_mod_password'] ) ),
		'date_last_mod_profile' => date ( 'd-m-Y', strtotime ( $user['date_last_mod_profile'] ) ),
		'date_register' => date ( 'd-m-Y', strtotime ( $user['date_register'] ) ),
		//
		'name' => $user['name'],
		'lastname' => $user['lastname'],
		'email' => $user['email'],
		'password' => $user['password'],
		//
		'cargo' => $user['cargo'],
		'vat' => $user['vat'],
		'phone' => $user['phone'],
		'mobile_phone' => $user['mobile_phone'],
		'fax' => $user['fax'],
		'address' => $user['address'],
		'description' => $user['description'],
		//
		'status_id' => $user['status_id'],
		'status' => tr ( '_GLOBAL' . $user['status'] ),
		'permission_id' => $user['permission_id'],
		'permission' => tr ( '_GLOBAL' . $user['permission'] ),
		'permission_class' => $user['permission_class'],
		'language' => $user['language'],
		'language_id' => $user['language_id'],
		//
		'avatar' => (!empty ( $user['avatar'] ) ) ? $this->template->thumb ( 'uploads', $user['avatar'], array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) ) : $this->template->thumb ( 'img', '_avatars/avatar.png', array( 'w' => 150, 'h' => 150, 'type' => 'resize' ) )
	    );
	}

	unset ( $users, $user );

	return ($single) ? $return[0] : $return;
    }

}
