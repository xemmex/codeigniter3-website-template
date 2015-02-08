<?php

defined ( 'BASEPATH' ) OR exit ( 'No direct script access allowed' );

/**
 * Template Class
 *
 * Template engine for views, assets and models.
 *
 * @package		CodeIgniter
 * @subpackage		Libraries
 * @category		Template
 * @author		Nicolás Martinez @nicojmb
 * @link		http://www.nicojmb.com
 */
class Template
{

    /**
     * CODEIGNITER INSTANCE
     *
     * @access protected
     * @var object
     */
    protected $_ci;

    /**
     * PATHS
     *
     * @access public
     * @var array
     */
    protected $_path;

    /**
     * CONFIGURATION DATA
     *
     * @access protected
     * @var array
     */
    protected $_config = array(
	'themes_system' => 'frontend',
	'themes_default' => 'default',
	'template_default' => 'layout',
	'page_title' => 'Unset Title',
	'asset_path' => 'assets',
	'asset_css_path' => 'css',
	'asset_js_path' => 'js',
	'asset_less_path' => 'less',
	'asset_img_path' => 'img',
	'asset_swf_path' => 'swf',
	'asset_xml_path' => 'xml',
	'asset_ico_path' => 'ico',
	'asset_library_path' => '_library',
	'asset_plugins_path' => '_plugins',
	'downloads_path' => '_downloads',
	'uploads_path' => '_uploads',
	'thumbs_path' => '_thumbs'
    );

    /**
     * DATA MODEL
     *
     * @access protected
     * @var array
     */
    protected $_data = array(
	'css' => array(),
	'css_ext' => '',
	'js' => array(),
	'js_ext' => '',
	'plugins' => array(),
	'library' => array(),
	'body' => '',
	'body_class' => '',
	'views' => array()
    );

    /**
     * VIEWS CONTAINER
     *
     * @access protected
     * @var array
     */
    protected $_views = array();

    /**
     * CONSTRUCTOR
     *
     */
    public function __construct ( $config = array() )
    {
	// Load the ci instance
	$this->_ci = & get_instance ();

	self::_set_config ( $config );
	self::_set_paths ();
    }

    /**
     * SET PARAMETERS
     *
     * @param  string	$property 	Name of the property to be set
     * @param  string 	$value		Value of the property
     * @param  string 	$ext_value	Extra values of the property
     *
     * @return string
     */
    public function set ( $property = '', $value = '', $ext_value = NULL )
    {
	switch ( $property )
	{

	    // Plugin
	    case 'plugins' :
	    case 'library' :

		if ( is_array ( $ext_value ) )
		{
		    foreach ( $ext_value as $ext_value_single )
		    {
			$this->_data[$property][$value][] = $ext_value_single;
		    }
		}
		else
		{
		    $this->_data[$property][$value][] = $ext_value;
		}
		break;

	    // CSS & JS
	    case 'css' :
	    case 'js' :
		if ( isset ( $ext_value ) && !empty ( $ext_value ) )
		{
		    if ( $property == 'css' )
		    {
			$this->_data['css_ext'] .= $value . PHP_EOL;
		    }
		    else
		    if ( $property == 'js' )
		    {
			$this->_data['js_ext'] .= $value . PHP_EOL;
		    }
		    else
		    {
			return FALSE;
		    }
		}
		else
		{
		    if ( is_array ( $value ) && !empty ( $value ) )
		    {
			// Validate array structure
			foreach ( $value as $css => $date )
			{
			    if ( isset ( $date ) && is_numeric ( $date ) && strlen ( $date ) >= 3 )
			    {
				$this->_data[$property][$css] = $date;
			    }
			    else
			    {
				$this->_data[$property][] = $date;
			    }
			}
		    }
		    else
		    if ( is_string ( $value ) )
		    {
			$this->_data[$property][] = $value;
		    }
		    else
		    {
			return FALSE;
		    }
		}
		break;

	    // VIEWS
	    case 'view' :
	    case 'views' :
		if ( is_array ( $value ) && !empty ( $value ) )
		{
		    // Validate array structure
		    foreach ( $value as $asset )
		    {
			$this->_views[] = $asset;
		    }
		}
		else
		if ( is_string ( $value ) )
		{
		    $this->_views[] = $value;
		}
		else
		{
		    return FALSE;
		}

		break;

	    // DATA
	    case 'data' :
		if ( isset ( $ext_value ) && $ext_value == TRUE )
		{
		    $this->_data[] = $value;
		}
		else
		{
		    $this->_data[$property] = $value;
		}
		break;

	    // TEMPLATE
	    case 'template' :
		if ( is_string ( $value ) )
		{
		    if ( file_exists ( $this->_path['views_basepath'] . '/' . $value . '.php' ) )
		    {
			$this->_config['template_default'] = $value;
		    }
		    else
		    {
			show_error ( 'Unable to find template file: ' . $this->_path['views_basepath'] . '/' . $value . '.php' );
		    }
		}
		else
		{
		    show_error ( 'You must enter the name of a template.' );
		}
		break;

	    // THEME
	    case 'theme' :
		if ( is_string ( $value ) )
		{
		    if ( is_dir ( $this->_path['base'] . '/' . $value ) )
		    {
			$this->_config['themes_default'] = $value;
			self::_set_paths ();
		    }
		    else
		    {
			show_error (
				'<strong>Template library:</strong><br />' .
				'Unable to locate "theme" directory (' . $this->_path['base'] . '/' . $value . '), check configuration in database'
			);
		    }
		}
		else
		{
		    show_error ( 'You must enter the name of a theme directory.' );
		}
		break;


	    // BREAK
	    default :
		break;
	}

	return $this;
    }

    /**
     * RENDER TEMPLATE
     *
     * @param  bool	$return	    Set TRUE if return view as string
     *
     * @return mixed
     */
    public function render ( $return = FALSE )
    {
	if ( !$return )
	{
	    $this->_ci->load->view ( $this->_path['views'] . '/' . $this->_config['template_default'], self::_parse_data () );
	}
	else
	{
	    return $this->_ci->load->view ( $this->_path['views'] . '/' . $this->_config['template_default'], self::_parse_data (), TRUE );
	}
    }

    /**
     * PATH Helper
     *
     * @param  string 	$type 		Type of Path to return
     * @param  string 	$file 		File name without extension of IMG file
     * @param  bool 	$fullpath 	Full local path. Example: /var/home/www/assets/_uploads
     *
     * @return string
     */
    public function path ( $type = '', $file = '', $fullpath = FALSE )
    {
	$file = ( isset ( $file ) && !empty ( $file ) ) ? '/' . $file : '';
	$fullpath = ($fullpath === TRUE) ? FCPATH : str_replace ( '/index.php', '', $_SERVER['SCRIPT_NAME'] ) . '/';

	if ( $type == 'assets' )
	{
	    return $fullpath . $this->_path['assets'] . '/';
	}
	else
	if ( array_key_exists ( 'asset_' . $type . '_path', $this->_config ) )
	{
	    return $fullpath . $this->_path['assets'] . '/' . $this->_config['asset_' . $type . '_path'] . $file;
	}
	else
	if ( array_key_exists ( $type . '_path', $this->_config ) )
	{
	    return $fullpath . $this->_config['asset_path'] . '/' . $this->_config[$type . '_path'] . $file;
	}
	else
	{
	    show_error (
		    '<strong>Template library:</strong><br />' .
		    'Unknown parameter "' . $type . '", only availible (css, js, uploads, downloads, swf, img, less, ico, library, plugins)'
	    );
	}
    }

    /**
     * LINK Helper
     *
     * @param  string	$path 	Location of FILE, can be "uploads", "downloads" or "img".
     * @param  string	$file 	File name with extension
     *
     * @return string
     */
    public function link ( $path = 'img', $file = NULL )
    {
	return self::path ( $path, $file );
    }

    /**
     * WIDGET Helper
     *
     * @param  string	$widget	    Widget template name
     * @param  string	$model	    Model name to load
     * @param  string	$method	    Method to call in model
     * @param  array	$params	    Params to pass a model method
     * @param  string	$var	    Variable name to return data to manage in view
     *
     * @return string
     */
    public function widget ( $widget = NULL, $model = NULL, $method = NULL, $params = array(), $var = 'entries' )
    {
	if ( file_exists ( $this->_path['views_basepath'] . '/widgets/' . $widget . '.php' ) )
	{
	    if ( isset ( $model ) && isset ( $method ) )
	    {
		if ( file_exists ( $this->_path['models_basepath'] . '/' . ucfirst ( $model ) . '.php' ) )
		{
		    $this->_ci->load->model ( $this->_path['models'] . '/' . $model );
		    $data['widget'][$var] = $this->_ci->$model->$method ( $params );
		}
		else
		{
		    show_error (
			    '<strong>Template library:</strong><br />' .
			    'Unable to locate model (' . $this->_path['models_basepath'] . '/' . ucfirst ( $model ) . '.php' . ').<br/>Check Model name in current Widget<br />'
		    );
		}

		echo $this->_ci->load->view ( $this->_path['views'] . '/widgets/' . $widget, $data, TRUE ) . PHP_EOL;
	    }
	    else
	    {
		echo $this->_ci->load->view ( $this->_path['views'] . '/widgets/' . $widget, NULL, TRUE ) . PHP_EOL;
	    }
	}
	else
	{
	    show_error (
		    '<strong>Template library:</strong><br />' .
		    'Unable to locate widget (' . $this->_path['theme'] . '/widgets/' . $widget . ').<br/>Check Widget name in current VIEW<br />'
	    );
	}
    }

    /**
     * VIEW Helper
     *
     * @param  string	$view		View Controller name
     * @param  string	$data		Param to put un function Model
     *
     * @return string
     */
    public function view ( $view = NULL, $data = NULL )
    {
	if ( file_exists ( $this->_path['views_basepath'] . '/' . trim ( $view ) . '.php' ) )
	{
	    echo $this->_ci->load->view ( $this->_path['views'] . '/' . trim ( $view ), $data, TRUE ) . PHP_EOL;
	}
	else
	{
	    show_error (
		    '<strong>Template library:</strong><br />' .
		    'Unable to locate view (' . $this->_path['views'] . '/' . trim ( $view ) . '.php' . ').<br/>Check the view name in current views/controller folder<br />'
	    );
	}
    }

    /**
     * FAVICON Helper
     *
     * @param  string	$path 	Location of ICO File
     * @param  string	$file 	File name without extension of ICO file
     * @param  string	$atts	Attributes of ICO file
     *
     * @return string
     */
    public function favicon ( $path = 'ico', $file = NULL, $atts = array() )
    {
	$return = '<link rel="shortcut icon" type="image/x-icon" href="' . self::path ( $path, $file ) . '"';

	foreach ( $atts as $key => $val )
	{
	    $return .= ' ' . $key . '="' . $val . '"';
	}

	$return .= '/>' . PHP_EOL;

	return $return;
    }

    /**
     * IMG Helper
     *
     * @param  string	$path 	Location of IMG File, can be "uploads", "downloads" or "img".
     * @param  string	$file 	File name without extension of IMG file
     * @param  string	$atts	Attributes of IMG file
     *
     * @return string
     */
    public function img ( $path = 'img', $file = NULL, $atts = array( 'alt' => '' ) )
    {
	$return = '<img src="' . self::path ( $path, $file ) . '"';

	foreach ( $atts as $key => $val )
	{
	    $return .= ' ' . $key . '="' . $val . '"';
	}

	$return .= '/>';

	return $return;
    }

    /**
     * DELETE Helper
     *
     * @param  string 	$path	    Location of IMG File, can be "uploads", "downloads" or "img".
     * @param  string 	$file	    Fullname of file
     *
     * @return bool
     */
    public function delete ( $path = 'uploads', $file = NULL )
    {
	$path = self::path ( $path, NULL, TRUE );
	$thumbs = self::path ( 'thumbs', NULL, TRUE );

	if ( isset ( $file ) && !empty ( $file ) && file_exists ( $path . '/' . $file ) )
	{
	    // Delete all thumbs
	    $file_info = pathinfo ( $path . '/' . $file );
	    $files = glob ( $thumbs . '/' . "*" . $file_info['basename'] );

	    if ( isset ( $files ) && is_array ( $files ) && !empty ( $files ) )
	    {
		foreach ( $files as $thumb )
		{
		    if ( is_file ( $thumb ) )
		    {
			unlink ( $thumb );
		    }
		}
	    }

	    unset ( $files, $thumb, $file_info );

	    // Delete image if is a file
	    if ( is_file ( $path . '/' . $file ) )
	    {
		return unlink ( $path . '/' . $file );
	    }
	    else
	    {
		return FALSE;
	    }
	}

	return FALSE;
    }

    /**
     * THUMB Helper
     *
     * @param  string 	$path	    Location of IMG File, can be "uploads", "downloads" or "img".
     * @param  string 	$file	    File name without extension of IMG file
     * @param  array	$config	    Parameter por Image Thumb
     * @param  array	$no_image   Return NO IMAGE if image not exist un server
     *
     * @return string
     */
    public function thumb ( $path = 'uploads', $file = NULL, $config = array( 'w' => NULL, 'h' => NULL ), $no_image = FALSE )
    {
	// Parameters Image
	$config['type'] = (isset ( $config['type'] ) && !empty ( $config['type'] ) ) ? $config['type'] : 'resize';
	$config['w'] = (isset ( $config['w'] )) ? $config['w'] : 300;
	$config['h'] = (isset ( $config['h'] )) ? $config['h'] : 150;
	$config['bgcolor'] = (isset ( $config['bgcolor'] )) ? $config['bgcolor'] : '#FFF';

	$config['watermark'] = (isset ( $config['watermark'] )) ? ( bool ) $config['watermark'] : FALSE;
	$config['watermark_image'] = $this->_ci->settings_model->system['_system_image_watermark_'];
	$config['watermark_transparency'] = (isset ( $config['watermark_transparency'] )) ? $config['watermark_transparency'] : $this->_ci->settings_model->system['_system_image_watermark_transparency_'];
	$config['watermark_position'] = (isset ( $config['watermark_position'] )) ? $config['watermark_position'] : $this->_ci->settings_model->system['_system_image_watermark_position_'];

	// Original Image
	$src_image = self::path ( $path, $file, TRUE );
	$not_image = self::path ( $path, $this->_ci->settings_model->system['_system_image_not_available_'], TRUE );

	// Check File
	if ( (empty ( $file ) || !file_exists ( $src_image ) ) && file_exists ( $not_image ) )
	{
	    return self::thumb ( 'uploads', $this->_ci->settings_model->system['_system_image_not_available_'], $config, FALSE );
	}
	else
	if ( !empty ( $file ) && file_exists ( $src_image ) )
	{
	    $file_info = pathinfo ( $src_image );
	    $new_file = $config['w'] . '_' . $config['h'] . '_' . $config['type'] . '_' . $file_info['basename'];
	    $dst_image = '.' . self::path ( 'thumbs', $new_file );
	}
	else
	{
	    show_error (
		    '<strong>Template library:</strong><br />' .
		    'Unable to locate "NO IMAGE" (' . $not_image . '), check configuration in database and folder permissions'
	    );

	    return '';
	}

	if ( !file_exists ( $dst_image ) )
	{

	    // Load Library
	    $this->_ci->load->library ( 'image_moo' );

	    // Load Image
	    $this->_ci->image_moo->load ( $src_image );

	    // Image Manipulation
	    if ( $config['type'] == 'crop' )
	    {
		$this->_ci->image_moo->resize_crop ( $config['w'], $config['h'] );
	    }
	    else
	    if ( $config['type'] == 'stretch' )
	    {
		$this->_ci->image_moo->stretch ( $config['w'], $config['h'] );
	    }
	    else
	    if ( $config['type'] == 'resize' )
	    {
		$this->_ci->image_moo->resize ( $config['w'], $config['h'] );
	    }
	    else
	    if ( $config['type'] == 'resize_ratio' )
	    {
		$this->_ci->image_moo->resize ( $config['w'], $config['h'], TRUE );
	    }

	    // Watermak
	    if ( ( bool ) $config['watermark'] === TRUE && ( bool ) $this->_ci->settings_model->system['_system_image_watermark_status_'] == TRUE )
	    {
		$this->_ci->image_moo->load_watermark ( $config['watermark_image'] );
		$this->_ci->image_moo->set_watermark_transparency ( $config['watermark_transparency'] );
		$this->_ci->image_moo->watermark ( $config['watermark_position'] );
	    }

	    // Save Image
	    $this->_ci->image_moo->save ( $dst_image );
	}

	unset ( $file, $file_info, $src_image, $config, $new_file, $no_image, $path, $not_image );

	// Return Image Link
	return substr ( $dst_image, 1 );
    }

    /**
     * SWF Helper
     *
     * @param  string	$file 	File name without extension of SWF file
     * @param  string	$atts	Attributes of SWF file
     *
     * @return string
     */
    public function swf ( $file = NULL, $atts = array( 'width' => '100', 'height' => '50' ) )
    {
	$return = '<object data="' . self::path ( 'swf', $file . '.swf' ) . '" ';

	foreach ( $atts as $key => $val )
	{
	    $return .= ' ' . $key . '="' . $val . '"';
	}

	$return .= '></object>' . PHP_EOL;

	return $return;
    }

    /**
     * LESS Helper
     *
     * @param  string	$file 	File name without extension of LESS file
     * @param  string	$atts	Attributes of LESS file
     *
     * @return string
     */
    public function less ( $file = NULL, $atts = array() )
    {
	$return = '<link rel="stylesheet" type="text/css" href="' . self::path ( 'less', $file . '.less' ) . '"';

	foreach ( $atts as $key => $val )
	{
	    $return .= ' ' . $key . '="' . $val . '"';
	}

	$return .= '/>' . PHP_EOL;

	return $return;
    }

    /**
     * Touch Helper
     *
     * @param  string	$file	    Type of plugin (css or js)
     * @param  string	$size	    File name without extension of CSS file
     * @param  string	$rel        Type of icon
     * @param  bool 	$br	    Breakline
     *
     * @return string
     */
    public function touch ( $file = NULL, $size = '', $rel = 'apple-touch-icon-precomposed', $br = TRUE )
    {

	$sizes = (isset ( $size ) && !empty ( $size )) ? ' sizes="' . $size . '"' : '';
	$return = '<link rel="' . $rel . '"' . $sizes . ' href="' . self::path ( 'img', $file ) . '">';

	return ( $br ) ? $return . PHP_EOL : $return;
    }

    /**
     * Plugins Helper
     *
     * @param  string	$type	    Type of plugin (css or js)
     * @param  string	$file	    File name without extension of CSS file
     * @param  string	$version    Version of CSS or JS file to reload in cache servers
     * @param  string	$atts	    Attributes of CSS file
     * @param  bool 	$br	    Breakline
     *
     * @return string
     */
    public function plugin ( $type = 'css', $file = NULL, $version = '', $atts = array(), $br = TRUE )
    {
	return self::$type ( $file, $version, $atts, $br, 'plugins' );
    }

    /**
     * Library Helper
     *
     * @param  string	$type	    Type of plugin (css or js)
     * @param  string	$file	    File name without extension of CSS file
     * @param  string	$version    Version of CSS or JS file to reload in cache servers
     * @param  string	$atts	    Attributes of CSS file
     * @param  bool 	$br	    Breakline
     *
     * @return string
     */
    public function library ( $type = 'css', $file = NULL, $version = '', $atts = array(), $br = TRUE )
    {
	return self::$type ( $file, $version, $atts, $br, 'library' );
    }

    /**
     * CSS Helper
     *
     * @param  string	$file	    File name without extension of CSS file
     * @param  string	$version    Version of CSS file to reload in cache servers
     * @param  string	$atts	    Attributes of CSS file
     * @param  bool 	$br	    Breakline
     * @param  bool 	$path	    Path of CSS
     *
     * @return string
     */
    public function css ( $file = NULL, $version = '', $atts = array(), $br = TRUE, $path = 'css' )
    {
	$version = (!empty ( $version ) ) ? '.css?v=' . $version : '.css';

	$return = '<link href="' . self::path ( $path, $file . $version ) . '" rel="stylesheet"';

	foreach ( $atts as $key => $val )
	{
	    $return .= ' ' . $key . '="' . $val . '"';
	}

	$return .= '>';

	return ( $br ) ? $return . PHP_EOL : $return;
    }

    /**
     * JS Helper
     *
     * @param  string	$file	    File name without extension of JS file
     * @param  string	$version    Version of JS file to reload in cache servers
     * @param  string	$atts	    Attributes of JS file
     * @param  bool 	$br	    Breakline
     * @param  bool 	$path	    Path of JS
     *
     * @return string
     */
    public function js ( $file = NULL, $version = '', $atts = array(), $br = TRUE, $path = 'js' )
    {
	$version = (!empty ( $version ) ) ? '.js?v=' . $version : '.js';

	$return = '<script type="text/javascript" src="' . self::path ( $path, $file . $version ) . '"';

	foreach ( $atts as $key => $val )
	{
	    $return .= ' ' . $key . '="' . $val . '"';
	}

	$return .= '></script>';

	return ( $br ) ? $return . PHP_EOL : $return;
    }

    /**
     * JS Helper
     *
     * @param  string	$file	    File name without extension of JS file
     * @param  string	$version    Version of JS file to reload in cache servers
     * @param  string	$atts	    Attributes of JS file
     * @param  bool 	$br	    Breakline
     *
     * @return string
     */
    public function js_simple ( $file = NULL, $version = '', $atts = array(), $br = TRUE )
    {
	$version = (!empty ( $version ) ) ? '.js?v=' . $version : '.js';

	$return = '<script src="' . self::path ( 'js', $file . $version ) . '"';

	foreach ( $atts as $key => $val )
	{
	    $return .= ' ' . $key . '="' . $val . '"';
	}

	$return .= '></script>';

	return ( $br ) ? $return . PHP_EOL : $return;
    }

    /**
     * JQUERY JS Helper
     *
     * @param	string	$version    Version of JQuery
     * @param	string	$return	    Add extra return data to function
     *
     * @return string
     */
    public function jquery ( $version = '', $return = '' )
    {
	$return .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/' . $version . '/jquery.min.js"></script>' . PHP_EOL;
	$return .= '<script>window.jQuery || document.write(\'<script src="' . self::path ( 'js', 'jquery-' . $version . '.min.js' ) . '"><\/script>\')</script>' . PHP_EOL;
	return $return;
    }

    /**
     * GOOGLE ANALYTICS Helper
     *
     * @param	string	$ua	    Google Analytics Acount
     * @param	string	$return	    Add extra return data to function
     *
     * @return string
     */
    public function google_analytics ( $ua = '', $return = '' )
    {
	$return .= "<!-- Google Webmaster Tools & Analytics -->" . PHP_EOL;
	$return .='<script type="text/javascript">';
	$return .='	var _gaq = _gaq || [];';
	$return .="    _gaq.push(['_setAccount', " . $ua . "]);";
	$return .="    _gaq.push(['_trackPageview']);";
	$return .='    (function() {';
	$return .="      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
	$return .="      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
	$return .="      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
	$return .="    })();";
	$return .="</script>" . PHP_EOL;

	return $return;
    }

    /**
     * PARSE_DATA Helper
     *
     * @access private
     * @return string
     */
    private function _parse_data ()
    {
	$data = self::_parse_seo ( $this->_data );

	$data['css'] = self::_parse_css_external ();
	$data['css_plugins'] = self::_parse_plugins ( 'css' );
	$data['css'] .= self::_parse_css ();

	$data['js_plugins'] = self::_parse_plugins ( 'js' );
	$data['js_external'] = self::_parse_js_external ();
	$data['javascript'] = self::_parse_js ();

	$data['body'] = self::_parse_body ();

	unset ( $this->_data, $data['js'] );

	return $data;
    }

    /**
     * PARSE_SEO Helper
     *
     * @param  array 	$data	Return string.
     *
     * @access private
     * @param  array
     * @return array
     */
    private function _parse_seo ( $data = array(), $match = "/^[_](.*[_])?$/" )
    {
	$CI = & get_instance ();

	if ( ( isset ( $data['data']['seo_title'] ) && preg_match ( $match, $data['data']['seo_title'], $matches ) ) || empty ( $data['data']['seo_title'] ) )
	{
	    $data['data']['seo_title'] = $CI->settings_model->system['_seo_title_'];
	}

	if ( ( isset ( $data['data']['seo_keywords'] ) && preg_match ( $match, $data['data']['seo_keywords'], $matches ) ) || empty ( $data['data']['seo_keywords'] ) )
	{
	    $data['data']['seo_keywords'] = $CI->settings_model->system['_seo_keywords_'];
	}

	if ( ( isset ( $data['data']['seo_description'] ) && preg_match ( $match, $data['data']['seo_description'], $matches ) ) || empty ( $data['data']['seo_description'] ) )
	{
	    $data['data']['seo_description'] = $CI->settings_model->system['_seo_description_'];
	}

	unset ( $matches );

	return $data;
    }

    /**
     * PARSE_BODY Helper
     *
     * @param  string 	$return	    Return string.
     *
     * @access private
     * @return string
     */
    private function _parse_body ( $return = '' )
    {
	if ( is_array ( $this->_views ) && !empty ( $this->_views ) )
	{
	    foreach ( $this->_views as $view )
	    {

		if ( file_exists ( $this->_path['views_basepath'] . '/' . $view . '.php' ) )
		{
		    $return .= $this->_ci->load->view ( $this->_path['views'] . '/' . $view, $this->_data, TRUE ) . PHP_EOL;
		}
		else
		{
		    show_error (
			    '<strong>Template library:</strong><br />' .
			    'Unable to locate view (' . $this->_path['views_basepath'] . '/' . $view . '.php).<br/>Check view name in controller<br />'
		    );
		}
	    }
	}
	else
	{
	    $return .= $this->_data;
	}

	return $return;
    }

    /**
     * PARSE_LIBRARY Helper
     *
     * @param  array 	$type	    CSS or JS
     * @param  array 	$library    Array of PLUGINS file to add to template
     * @param  string 	$return	    Return string, can be set before add CSS files
     *
     * @access private
     * @return string
     */
    private function _parse_library ( $type = 'css', $library = array(), $return = '' )
    {

	$array = (isset ( $library ) && is_array ( $library ) && !empty ( $library )) ? $library : $this->_data['library'][$type];

	foreach ( $array as $type => $lib )
	{
	    $return .= '';
	}

	return $return;
    }

    /**
     * PARSE_PLUGIN Helper
     *
     * @param  array 	$type	    CSS or JS
     * @param  array 	$plugins    Array of PLUGINS file to add to template
     * @param  string 	$return	    Return string, can be set before add CSS files
     *
     * @access private
     * @return string
     */
    private function _parse_plugins ( $type = 'css', $plugins = array(), $return = '' )
    {
	$array = (isset ( $this->_data['plugins'][$type] ) && is_array ( $this->_data['plugins'][$type] ) && !empty ( $this->_data['plugins'][$type] )) ? $this->_data['plugins'][$type] : $plugins;

	foreach ( $array as $p => $plugin )
	{
	    $current_plugin = current ( $plugin );
	    $return .= (is_array ( $plugin ) && !empty ( $current_plugin ) && is_numeric ( $current_plugin )) ? self::plugin ( $type, key ( $plugin ), $current_plugin ) : self::plugin ( $type, $plugin );
	}

	unset ( $this->_data['plugins'][$type], $type, $plugin, $array, $p, $plugins, $current_plugin );

	return $return;
    }

    /**
     * PARSE_CSS_EXTERNAL Helper
     *
     * @param  string 	$return	    Return string, can be set before add CSS files
     *
     * @access private
     * @return string
     */
    private function _parse_css_external ( $return = '' )
    {
	$return .= $this->_data['css_ext'];

	unset ( $this->_data['css_ext'] );

	return $return;
    }

    /**
     * PARSE_CSS Helper
     *
     * @param  array 	$css	    Array of CSS file to add to template
     * @param  string 	$return	    Return string, can be set before add CSS files
     *
     * @access private
     * @return string
     */
    private function _parse_css ( $css = array(), $return = '' )
    {

	$array = (isset ( $css ) && is_array ( $css ) && !empty ( $css )) ? $css : $this->_data['css'];

	foreach ( $array as $css => $date )
	{
	    $return .= (isset ( $date ) && !empty ( $date ) && is_numeric ( $date )) ? self::css ( $css, $date, array(), TRUE ) : self::css ( $date, '', array(), TRUE );
	}

	unset ( $this->_data['css'], $css, $array, $css, $date );

	return $return;
    }

    /**
     * PARSE_JS_EXTERNAL Helper
     *
     * @param  string 	$return	    Return external javascript strings
     *
     * @access private
     * @return string
     */
    private function _parse_js_external ( $return = '' )
    {
	$return .= $this->_data['js_ext'];

	unset ( $this->_data['js_ext'] );

	return $return;
    }

    /**
     * PARSE_JS Helper
     *
     * @param  array 	$js	    Array of JS file to add to template
     * @param  string 	$return	    Return string, can be set before add JS files
     *
     * @access private
     * @return string
     */
    private function _parse_js ( $js = array(), $return = '' )
    {

	$array = (isset ( $js ) && is_array ( $js ) && !empty ( $js )) ? $js : $this->_data['js'];

	foreach ( $array as $js => $date )
	{
	    $return .= (isset ( $date ) && !empty ( $date ) && is_numeric ( $date )) ? self::js ( $js, $date, array(), TRUE ) : self::js ( $date, '', array(), TRUE );
	}

	unset ( $this->_data['js'], $js, $array, $css, $date );

	return $return;
    }

    /**
     * SET CONFIG
     *
     * @param  array 	$config	    Default config change
     *
     * @access protected
     * @return void
     */
    protected function _set_config ( $config = array() )
    {
	if ( isset ( $config ) && !empty ( $config ) )
	{
	    foreach ( $config as $param => $value )
	    {
		$this->_config[$param] = $value;
	    }
	}
    }

    /**
     * SET PATHS
     *
     * @access protected
     * @return void
     */
    protected function _set_paths ()
    {
	// BASEPATHS
	if ( is_dir ( APPPATH . 'views/' . $this->_config['themes_system'] . '/' . $this->_config['themes_default'] ) )
	{
	    $this->_path['views_basepath'] = APPPATH . 'views/' . $this->_config['themes_system'] . '/' . $this->_config['themes_default'];
	    $this->_path['helpers_basepath'] = APPPATH . 'helpers/' . $this->_config['themes_system'];
	    $this->_path['models_basepath'] = APPPATH . 'models/' . $this->_config['themes_system'];

	    $this->_path['views'] = $this->_config['themes_system'] . '/' . $this->_config['themes_default'];
	    $this->_path['helpers'] = $this->_config['themes_system'];
	    $this->_path['models'] = $this->_config['themes_system'];
	}
	else
	{
	    show_error ( 'Review line: 1037 ' );
	}

	// Assets Path
	if ( is_dir ( FCPATH . $this->_config['asset_path'] . '/' . $this->_config['themes_system'] . '/' . $this->_config['themes_default'] ) )
	{
	    $this->_path['assets'] = $this->_config['asset_path'] . '/' . $this->_config['themes_system'] . '/' . $this->_config['themes_default'];
	}
	else
	{
	    show_error (
		    '<strong>Template library:</strong><br />' .
		    'Unable to locate "ASSETS" directory (' . $this->_config['asset_path'] . '/' . $this->_config['themes_path'] . '/' . $this->_config['themes_system'] . '/' . $this->_config['themes_default'] . '), check configuration in database'
	    );
	}
    }

}
