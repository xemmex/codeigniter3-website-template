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
