<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

/**
 * Extend - Form Validation Class
 *
 * Template engine for views, assets and models.
 *
 * @package		CodeIgniter
 * @subpackage		Libraries
 * @category		Validation
 * @author		Nicolás Martinez @nicojmb
 * @link		http://www.nicojmb.com
 */
class MY_Form_validation extends CI_Form_validation
{

    /**
     * Custom patterns
     */
    public function pattern ( $str, $type = NULL )
    {
	switch ( $type )
	{
	    case 'email':
		$reg = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/u';
		break;
	    case 'alpha':
		$reg = '/^([a-z])+$/ui';
		break;
	    case 'alpha_numeric':
		$reg = '/^([a-z0-9])+$/ui';
		break;
	    case 'alpha_dash':
		$reg = '/^([-a-z0-9_-])+$/ui';
		break;
	    case 'numeric':
		$reg = '/^[\-+]?[0-9]*\.?[0-9]+$/u';
		break;
	    case 'integer':
		$reg = '/^[\-+]?[0-9]+$/u';
		break;
	    case 'decimal':
		$reg = '/^[\-+]?[0-9]+\.[0-9]+$/u';
		break;
	    case 'point':
		$reg = '/^[\-+]?[0-9]+\.{0,1}[0-9]*\,[\-+]?[0-9]+\.{0,1}[0-9]*$/u';
		break;
	    case 'natural':
		$reg = '/^[0-9]+$/u';
		break;
	    default:
		$reg = '/' . $type . '/u';
		break;
	}
	if ( !preg_match ( $reg, $str ) )
	{
	    $this->set_message ( 'pattern', tr ( '_LIBRARY_FORM_pattern[' . $type . ']_error_' ) );
	    return FALSE;
	}

	return TRUE;
    }

    function valid_url ( $str )
    {

	$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
	if ( !preg_match ( $pattern, $str ) )
	{
	    return FALSE;
	}

	return TRUE;
    }

    /**
     * Verify that a string contains a specified number of
     * uppercase, lowercase, and numbers.
     *
     * @access public
     *
     * @param String $str
     * @param String $format
     *
     * @return int
     */
    public function password_check ( $str, $format )
    {
	$ret = TRUE;

	list($uppercase, $lowercase, $number) = explode ( ',', $format );

	$str_uc = $this->count_uppercase ( $str );
	$str_lc = $this->count_lowercase ( $str );
	$str_num = $this->count_numbers ( $str );

	if ( $str_uc < $uppercase ) // lacking uppercase characters
	{
	    $ret = FALSE;
	    $this->set_message ( 'password_check', tr ( '_LIBRARY_FORM_password_must_contain_at_least_' . $uppercase . '_uppercase_characters_' ) );
	}
	elseif ( $str_lc < $lowercase ) // lacking lowercase characters
	{
	    $ret = FALSE;
	    $this->set_message ( 'password_check', tr ( '_LIBRARY_FORM_password_must_contain_at_least_' . $lowercase . '_lowercase_characters_' ) );
	}
	elseif ( $str_num < $number ) //  lacking numbers
	{
	    $ret = FALSE;
	    $this->set_message ( 'password_check', tr ( '_LIBRARY_FORM_password_must_contain_at_least_' . $number . '_numbers_characters_' ) );
	}

	return $ret;
    }

    /**
     * count the number of times an expression appears in a string
     *
     * @access private
     *
     * @param String $str
     * @param String $exp
     *
     * @return int
     */
    private function count_occurrences ( $str, $exp )
    {
	$match = array();
	preg_match_all ( $exp, $str, $match );

	return count ( $match[0] );
    }

    /**
     * count the number of lowercase characters in a string
     *
     * @access private
     *
     * @param String $str
     *
     * @return int
     */
    private function count_lowercase ( $str )
    {
	return $this->count_occurrences ( $str, '/[a-z]/' );
    }

    /**
     * count the number of uppercase characters in a string
     *
     * @access private
     *
     * @param String $str
     *
     * @return int
     */
    private function count_uppercase ( $str )
    {
	return $this->count_occurrences ( $str, '/[A-Z]/' );
    }

    /**
     * count the number of numbers characters in a string
     *
     * @access private
     *
     * @param String $str
     *
     * @return int
     */
    private function count_numbers ( $str )
    {
	return $this->count_occurrences ( $str, '/[0-9]/' );
    }

}
