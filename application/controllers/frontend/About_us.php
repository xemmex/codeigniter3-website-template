<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class About_us extends Frontend_Controller
{

    public function index ()
    {

	$data['seo_description'] = tr ( '_SEO_FINCA_description_' );
	$data['seo_keywords'] = tr ( '_SEO_FINCA_keywords_' );
	$data['seo_title'] = tr ( '_SEO_FINCA_title_' );

	// Render Template & Views
	$this->template
		->set ( 'views', 'about_us/index' )
		->set ( 'data', $data )
		->render ();
    }

}
