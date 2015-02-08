<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

class Helper extends Backend_Controller
{

    private $rule_message;

    public function __construct ()
    {
	// Parent __construct
	parent::__construct ();

	// Load Helper
	$this->load->model ( 'backend/helper_model' );
    }

    public function change_editor ()
    {
	// Post Data
	$table = $this->input->post ( 'table', TRUE );
	$column = $this->input->post ( 'column', TRUE );
	$value = $this->input->post ( 'value', FALSE );
	$id = $this->input->post ( 'id', TRUE );
	$id_value = $this->input->post ( 'id_value', TRUE );
	$pk = $this->input->post ( 'pk', TRUE );
	$pk_value = $this->input->post ( 'pk_value', TRUE );

	if ( $this->helper_model->change_editor ( $table, $column, $value, $id, $id_value, $pk, $pk_value ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_MODEL_HELPER_SUCCESS_editor_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_MODEL_HELPER_ERROR_editor_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function change_default ()
    {

	// Post Data
	$table = $this->input->post ( 'table', TRUE );
	$column = $this->input->post ( 'column', TRUE );
	$id = $this->input->post ( 'id', TRUE );
	$id_value = $this->input->post ( 'id_value', TRUE );

	if ( $this->helper_model->change_default ( $table, $column, $id, $id_value ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_MODEL_HELPER_SUCCESS_change_default_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_MODEL_HELPER_ERROR_change_default_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function change_status ()
    {

	// Post Data
	$table = $this->input->post ( 'table', TRUE );
	$column = $this->input->post ( 'column', TRUE );
	$value = $this->input->post ( 'value', TRUE );
	$id = $this->input->post ( 'id', TRUE );
	$id_value = $this->input->post ( 'id_value', TRUE );
	$pk = $this->input->post ( 'pk', TRUE );
	$pk_value = $this->input->post ( 'pk_value', TRUE );

	if ( $this->helper_model->change_status ( $table, $column, $value, $id, $id_value, $pk, $pk_value ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_MODEL_HELPER_SUCCESS_status_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_MODEL_HELPER_ERROR_status_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function re_order ()
    {
	// Post Data
	$re_order = json_decode ( $this->input->post ( 'data', TRUE ), TRUE );

	if ( $this->helper_model->re_order ( $re_order ) )
	{
	    $json['status'] = TRUE;
	    $json['message'] = tr ( '_MODEL_HELPER_SUCCESS_re_order_' );
	}
	else
	{
	    $json['status'] = FALSE;
	    $json['message'] = tr ( '_MODEL_HELPER_ERROR_re_order_' );
	}

	// Output
	$this->output
		->set_header ( 'Content-Type: application/json; charset=utf-8' )
		->set_content_type ( 'application/json' )
		->set_output ( json_encode ( $json ) );
    }

    public function change_list ()
    {
	// Post Data
	$table = $this->input->post ( 'table', TRUE );
	$column = $this->input->post ( 'column', TRUE );
	$value = $this->input->post ( 'value', TRUE );
	$id = $this->input->post ( 'name', TRUE );
	$id_value = $this->input->post ( 'pk', TRUE );
	$rules = $this->input->post ( 'rules', TRUE );

	if ( self::_rules_validate ( $rules, $value ) === TRUE )
	{
	    if ( $this->helper_model->change_list ( $table, $column, $value, $id, $id_value ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_MODEL_HELPER_SUCCESS_change_list_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_MODEL_HELPER_ERROR_change_list_' );
	    }

	    // Output
	    $this->output
		    ->set_header ( 'Content-Type: application/json; charset=utf-8' )
		    ->set_content_type ( 'application/json' )
		    ->set_output ( json_encode ( $json ) );
	}
	else
	{
	    $this->output->set_status_header ( 500, $this->rule_message );
	}
    }

    public function change_value ()
    {
	// Post Data
	$table = $this->input->post ( 'table', TRUE );
	$column = $this->input->post ( 'column', TRUE );
	$value = $this->input->post ( 'value', TRUE );
	$id = $this->input->post ( 'name', TRUE );
	$id_value = $this->input->post ( 'pk', TRUE );
	$rules = $this->input->post ( 'rules', TRUE );

	if ( self::_rules_validate ( $rules, $value ) === TRUE )
	{
	    if ( $this->helper_model->change_value ( $table, $column, $value, $id, $id_value ) )
	    {
		$json['status'] = TRUE;
		$json['message'] = tr ( '_MODEL_HELPER_SUCCESS_change_value_' );
	    }
	    else
	    {
		$json['status'] = FALSE;
		$json['message'] = tr ( '_MODEL_HELPER_ERROR_change_value_' );
	    }

	    // Output
	    $this->output
		    ->set_header ( 'Content-Type: application/json; charset=utf-8' )
		    ->set_content_type ( 'application/json' )
		    ->set_output ( json_encode ( $json ) );
	}
	else
	{
	    $this->output->set_status_header ( 500, $this->rule_message );
	}
    }

    private function _rules_validate ( $rules = 'required', $value = NULL )
    {
	$rule = explode ( '|', $rules );

	foreach ( $rule as $i => $r )
	{
	    switch ( filter_var ( $r, FILTER_SANITIZE_STRING ) )
	    {
		case 'required' :
		    if ( !isset ( $value ) || empty ( $value ) )
		    {
			$this->rule_message = tr ( '_MODEL_HELPER_ERROR_RULE_required_' );
			return FALSE;
		    }
		    break;
		case 'valid_email' :
		    $this->load->helper ( 'email' );
		    if ( !valid_email ( $value ) )
		    {
			$this->rule_message = tr ( '_MODEL_HELPER_ERROR_RULE_valid_email_' );
			return FALSE;
		    }
		    break;
		case 'lowercase' :
		    if ( !ctype_lower ( $value ) )
		    {
			$this->rule_message = tr ( '_MODEL_HELPER_ERROR_RULE_lowercase_' );
			return FALSE;
		    }
		    break;
		case 'exact_length' :

		    if ( strlen ( $value ) !== ( int ) filter_var ( $r, FILTER_SANITIZE_NUMBER_INT ) )
		    {
			$this->rule_message = tr ( '_MODEL_HELPER_ERROR_RULE_exact_length_' );
			return FALSE;
		    }
		    break;
	    }
	}

	return TRUE;
    }

}
