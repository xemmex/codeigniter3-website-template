<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Install extends Install_Controller
{

    public function index ()
    {
	$data['requeriments'] = array(
	    'php_version' => array(
		'version' => '5.4.0',
		'name' => 'PHP Version 5.4.+',
		'description' => '',
		'result' => check_php_version ( '5.4.0' )
	    ),
	    'php_extension_mysqli' => array(
		'name' => 'MySqli Driver',
		'description' => '',
		'result' => check_php_extension ( 'mysqli' )
	    ),
	    'php_extension_pdo' => array(
		'name' => 'PDO Support',
		'description' => '',
		'result' => check_php_extension ( 'pdo' )
	    ),
	    'php_extension_gd2' => array(
		'name' => 'GD2 Lybrary',
		'description' => '',
		'result' => check_php_extension ( 'gd2' )
	    ),
	    'php_extension_mbstring' => array(
		'name' => 'MBstring',
		'description' => '',
		'result' => check_php_extension ( 'mbstring' )
	    )
	);

	$data['permissions'] = array(
	    'uploads' => array(
		'name' => 'Upload Path',
		'description' => 'Directory to uploads files',
		'result' => check_permissions ( '_uploads' )
	    ),
	    'thumbs' => array(
		'name' => 'Thumbs Path',
		'description' => 'Directory to save thumbnails',
		'result' => check_permissions ( '_thumbs' )
	    ),
	    'downloads' => array(
		'name' => 'Downloads Path',
		'description' => 'Directory save downloable files',
		'result' => check_permissions ( '_downloads' )
	    ),
	    'cache' => array(
		'name' => 'Cache Path',
		'description' => 'Directory to save cached files',
		'result' => check_permissions ( 'application/cache' )
	    ),
	    'log' => array(
		'name' => 'Log Path',
		'description' => 'Directory to write log files',
		'result' => check_permissions ( 'application/log' )
	    )
	);

	$this->load->view ( 'installation/index', $data );
    }

    public function generate_encryption_key ( $len = 32 )
    {

	$chars = array(
	    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
	    'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
	    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
	    'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
	);

	shuffle ( $chars );
	$num_chars = count ( $chars ) - 1;
	$token = '';

	for ( $i = 0; $i < $len; $i++ )
	{
	    $token .= $chars[mt_rand ( 0, $num_chars )];
	}

	die ( $token );
    }

    public function db_test_connection ( $len = 32 )
    {

	$config['hostname'] = $this->input->post ( 'db_host' );
	$config['username'] = $this->input->post ( 'db_username' );
	$config['password'] = $this->input->post ( 'db_password' );
	$config['database'] = $this->input->post ( 'db_database' );
	$config['dbdriver'] = $this->input->post ( 'db_driver' );
	$config['dbprefix'] = $this->input->post ( 'db_dbprefix' );

	try
	{
	    $this->load->database ( $config );

	    die ( 'Connection Succesfullly' );
	}
	catch ( Exception $e )
	{
	    die ( $e->getMessage () );
	}
    }

}

function check_php_version ( $version )
{
    return (version_compare ( PHP_VERSION, $version ) >= 0);
}

function check_php_extension ( $extension )
{
    return (extension_loaded ( $extension ));
}

function check_permissions ( $folder )
{
    return (is_writable ( APPPATH . $folder ));
}
