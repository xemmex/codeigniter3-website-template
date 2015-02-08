<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Villas extends Frontend_Controller
{

    public function villa_spa_i ()
    {
	$data['seo_description'] = tr ( '_SEO_VILLAS_VILLA_SPA_I_description_' );
	$data['seo_keywords'] = tr ( '_SEO_VILLAS_VILLA_SPA_I_keywords_' );
	$data['seo_title'] = tr ( '_SEO_VILLAS_VILLA_SPA_I_title_' );

	// Render Template & Views
	$this->template
		->set ( 'views', 'villas/villa_spa_i' )
		->set ( 'data', $data )
		->render ();
    }

    public function villa_spa_ii ()
    {
	$data['seo_description'] = tr ( '_SEO_VILLAS_VILLA_SPA_II_description_' );
	$data['seo_keywords'] = tr ( '_SEO_VILLAS_VILLA_SPA_II_keywords_' );
	$data['seo_title'] = tr ( '_SEO_VILLAS_VILLA_SPA_II_title_' );

	// Render Template & Views
	$this->template
		->set ( 'views', 'villas/villa_spa_ii' )
		->set ( 'data', $data )
		->render ();
    }

}
