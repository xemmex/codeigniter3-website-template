<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

/**
 * CodeIgniter Translate Helpers
 *
 * @package CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author      Nicolás Martinez
 * @link        http://www.nicojmb.com/ci/3.0/helpers/traductor.html
 */
/**
 * tr()
 * A Traductor function to translate string to user lang
 *
 * @author 	Nicolás Martinez
 * @param 	string $key
 * @return 	string
 */
if ( !function_exists ( 'tr' ) )
{

    /**
     * Trasnlate String
     *
     * Accepts one string parameter to search in database translations
     *
     * @param	string	the value of the cookie
     * @return	string
     */
    function tr ( $key = NULL )
    {

	// COdeigniter Instance
	$_ci = &get_instance ();

	$k = strtolower ( $key );

	$show_keys = $_ci->translate_model->show_keys;

	if ( isset ( $k ) && is_array ( $_ci->translate_model->keys ) && array_key_exists ( $k, $_ci->translate_model->keys ) )
	{

	    if ( $show_keys )
	    {
		return '<abbr title=' . $k . '>' . $_ci->translate_model->keys[$k] . '<abbr>';
	    }
	    else
	    {
		return $_ci->translate_model->keys[$k];
		// return htmlentities ( $_ci->translate_model->keys[$k], ENT_QUOTES );
	    }
	}
	else
	{
	    if ( $show_keys )
	    {
		return '<abbr title=' . $k . '>' . $k . '<abbr>';
	    }
	    else
	    {
		return $k;
	    }
	}
    }

}


if ( !function_exists ( 'get_languages' ) )
{

    function get_languages ( $all = FALSE )
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	return ($all === TRUE) ? $_ci->settings_model->all_languages : $_ci->settings_model->languages;
    }

}

if ( !function_exists ( 'current_language' ) )
{

    function current_language ( $var = 'code' )
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	return $_ci->settings_model->language[$var];
    }

}

if ( !function_exists ( 'all_languages' ) )
{

    function all_languages ( $uID = NULL, $var = 'code' )
    {

	// Codeigniter Instance
	$_ci = &get_instance ();

	return $_ci->settings_model->all_languages[array_search ( $uID, array_column ( $_ci->settings_model->all_languages, 'uID' ) )][$var];
    }

}

if ( !function_exists ( 'tr_key' ) )
{

    function tr_key ( $key )
    {

	return trim ( preg_replace ( '/__+/', '_', ('_' . (preg_replace ( '/\s+/', '_', $key )) . '_' ) ) );
    }

}

if ( !function_exists ( 'tr_text' ) )
{

    function tr_text ( $text )
    {
	return html_entity_decode ( str_replace ( array( '"', "'" ), array( "&quot;", "&#39;" ), $text ), ENT_NOQUOTES );
    }

}

if ( !function_exists ( 'tr_clean' ) )
{

    function tr_clean ( $text, $max_lenght = 200 )
    {

	$_text = trim ( stripslashes ( $text ) );
	$_text = strip_tags ( $_text );
	$_text = trim ( $_text, " \r\n\0\x0B" );
	$_text = str_replace ( '"', '&quot;', $_text );
	$_text = str_replace ( "'", ' & quot;
		', $_text );

	if ( preg_match ( '/^. {
		    1, 260
		}\b/s', $_text, $match ) )
	{
	    $line = $match[0];
	}
	else
	{
	    $line = '';
	}

	return ($max_lenght === FALSE) ? ucfirst ( strtolower ( trim ( $line ) ) ) : character_limiter ( ucfirst ( strtolower ( trim ( $line ) ) ), $max_lenght );
    }

}