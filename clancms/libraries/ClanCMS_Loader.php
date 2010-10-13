<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright	Copyright (c) 2010, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link		http://www.xcelgaming.com
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Loader Class
 *
 * @package		Clan CMS
 * @subpackage	Libraries
 * @category	Loader
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class ClanCMS_Loader extends CI_Loader {

	/**
	 * Constructor
	 *
	 */	
	function ClanCMS_Loader()
	{	
		// Call the Loader Constructor
		parent::CI_Loader();
		
		// Create an instance to CI
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Widget
	 *
	 * Loads a widget
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function widget($widget = '')
	{
		// Check if data is valid
		if ($widget == '')
		{
			// Data is invalid, return FALSE;
			return FALSE;
		}
		
		// Set up the widget path
		$widget_path = '/' . $widget;
            
		// Intialize sub directory
		$sub_directory = '';
		
		// Check for sub directory
		if (strpos($widget_path, '/') !== FALSE)
		{
			// explode the path so we can separate the filename from the path
			$x = explode('/', $widget_path);	
			
			// Reset the widget path now that we know the actual filename
			$widget = end($x);
			
			// Kill the filename from the array
			unset($x[count($x)-1]);
			
			// Create the sub directory path
			$sub_directory = implode($x, '/').'/';
		}
		
		// Create the widget's path
		$widget_path = APPPATH . 'widgets' . $sub_directory . $widget . '_widget.php';
		
		// Include the widget
        include_once($widget_path);
		
		// return the widget
        return $this->_ci_init_class($widget . '_widget');
	}

}

/* End of file ClanCMS_Loader.php */
/* Location: ./clancms/libraries/ClanCMS_Loader.php */