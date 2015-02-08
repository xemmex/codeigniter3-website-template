<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Home extends Frontend_Controller
{

    public function index ()
    {

	$data['seo_description'] = tr ( '_SEO_HOME_description_' );
	$data['seo_keywords'] = tr ( '_SEO_HOME_keywords_' );
	$data['seo_title'] = tr ( '_SEO_HOME_title_' );

	// Render Template & Views
	$this->template->set ( 'views', 'home/index' )->set ( 'data', $data )->render ();
    }

}
