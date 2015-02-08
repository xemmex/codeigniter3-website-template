<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Surroundings extends Frontend_Controller
{

    public function index ()
    {

	$data['seo_description'] = tr ( '_SEO_SURROUNDINGS_description_' );
	$data['seo_keywords'] = tr ( '_SEO_SURROUNDINGS_keywords_' );
	$data['seo_title'] = tr ( '_SEO_SURROUNDINGS_title_' );

	// Render Template & Views
	$this->template
		->set ( 'views', 'surroundings/index' )
		->set ( 'data', $data )
		->render ();
    }

}
