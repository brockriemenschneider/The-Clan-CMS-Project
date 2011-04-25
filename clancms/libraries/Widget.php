<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright	Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link		http://www.xcelgaming.com
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Widget Class
 *
 * @package		Clan CMS
 * @subpackage	Libraries
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Widget {

	public $CI;
	public $setting = array();
	public $widget_id = 0;
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{	
		// Create an instance to CI
		$this->CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * The widget's index
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// By default this does nothing
	}
	
	final function get_instance($widget_id = 0)
	{
		$this->widget_id = $widget_id;
		
		// Retrieve the widget
		if($widget = $this->CI->widgets->get_widget(array('widget_id' => $this->widget_id)))
		{
			// Assign the settings
			$this->setting = unserialize($widget->widget_settings);
		}
	}
}

/* End of file Widget.php */
/* Location: ./clancms/libraries/Widget.php */