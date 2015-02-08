<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Reservation extends Frontend_Controller
{

    public function index ()
    {

	$data['seo_description'] = tr ( '_SEO_RESERVATION_description_' );
	$data['seo_keywords'] = tr ( '_SEO_RESERVATION_keywords_' );
	$data['seo_title'] = tr ( '_SEO_RESERVATION_title_' );

	// Render Template & Views
	$this->template
		->set ( 'views', 'reservation/index' )
		->set ( 'data', $data )
		->render ();
    }

}
