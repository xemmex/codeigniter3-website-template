<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Dashboard extends Backend_Controller
{

    public function index ()
    {

	$data['seo_description'] = tr ( '_SEO_BACKEND_DASHBOARD_description_' );
	$data['seo_keywords'] = tr ( '_SEO_BACKEND_DASHBOARD_keywords_' );
	$data['seo_title'] = tr ( '_SEO_BACKEND_DASHBOARD_title_' );

	$this->template
		->set ( 'views', 'dashboard/index' )
		->set ( 'data', $data )
		->render ();
    }

}
