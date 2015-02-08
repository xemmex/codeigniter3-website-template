<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

if ( file_exists ( APPPATH . '/config/install.php' ) )
{
    require_once( APPPATH . "/config/install.php" );

    if ( isset ( $config['install_status'] ) && $config['install_status'] === TRUE )
    {
	require_once( dirname ( __FILE__ ) . "/frontend/Home.php" );

	class Base extends Home
	{

	    public function __construct ()
	    {
		parent::__construct ();
	    }

	}

    }
    else
    {
	require_once( dirname ( __FILE__ ) . "/installation/Install.php" );

	class Base extends Install
	{

	    public function __construct ()
	    {
		parent::__construct ();
	    }

	}

    }
}
else
{
    exit ( 'Install file is missing.' );
}