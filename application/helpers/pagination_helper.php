<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

/**
 * CodeIgniter Pagination Helper
 *
 * @package     CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author      Nicolás Martinez
 * @link        http://www.nicojmb.com/ci/3.0/helpers/auth.html
 */
if ( !function_exists ( 'pagination' ) )
{

    function pagination ( $base_url = '', $total_rows = NULL, $per_page = 10, $uri_segment = 4 )
    {
	// Codeigniter Instance
	$_ci = &get_instance ();

	// Load Library
	$_ci->load->library ( 'pagination' );

	// Pagination config
	$config['base_url'] = $base_url;
	$config['total_rows'] = $total_rows;
	$config['per_page'] = $per_page;
	$config['uri_segment'] = $uri_segment;
	$config['full_tag_open'] = '<ul class="pagination">';
	$config['full_tag_close'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="disabled"><li class="active"><a href="#">';
	$config['cur_tag_close'] = '<span class="sr-only"></span></a></li>';
	$config['next_tag_open'] = '<li>';
	$config['next_tagl_close'] = '</li>';
	$config['prev_tag_open'] = '<li>';
	$config['prev_tagl_close'] = '</li>';
	$config['first_tag_open'] = '<li>';
	$config['first_tagl_close'] = '</li>';
	$config['last_tag_open'] = '<li>';
	$config['last_tagl_close'] = '</li>';

	$_ci->pagination->initialize ( $config );

	// Return Pagination
	return $_ci->pagination->create_links ();
    }

}