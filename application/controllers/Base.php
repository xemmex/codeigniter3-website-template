<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

require_once( dirname ( __FILE__ ) . "/frontend/Home.php" );

class Base extends Home
{

    /**
     * Base Controller, Extend Home Public Controller
     *
     * Maps to the following URL
     * 		http://example.com/index.php/
     * 	- or with mod_rewrite -
     * 		http://example.com/
     */
    public function __construct ()
    {
	parent::__construct ();
    }

}
