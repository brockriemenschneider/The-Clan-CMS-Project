<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
	function __construct()
	{	
		// Call the Loader Constructor
		parent::__construct();
		
		// Create an instance to CI
		$CI =& get_instance();
		
		// Load the Widget model
		$this->model('Widgets_model', 'widgets');
	}
	
	// --------------------------------------------------------------------

	/**
	 * Widget
	 *
	 * Loads a widget
	 *
	 * @access	private
	 * @param	string
	 * @param	int
	 * @return	bool
	 */
	public function widget($widget = '', $widget_id = 0)
	{
		// Check if data is valid
		if ($widget == '')
		{
			// Data is invalid, return FALSE;
			return FALSE;
		}
		
		// Create the widget's path
		$widget_path = WIDGETS . $widget . '_widget.php';
		
		// Check if the widget file exists
		if(file_exists($widget_path) && $this->widgets->get_widget(array('widget_slug' => $widget)))
		{
			// Include the widget
			include_once($widget_path);
			
			// Assign class name
			$class_name = ucfirst(basename($widget . '_widget'));
			
			// Initiate the widget
			$widget = new $class_name();
			
			// Get the widget instance the widget
			$widget->get_instance($widget_id);
			
			// Return the widget
			return $widget->index();
		}
		else
		{
			// Widget doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Widget Area
	 *
	 * Loads a widget area
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function widget_area($area_slug = '')
	{	
		// Check if data is valid
		if(!$area = $this->widgets->get_area(array('area_slug' => $area_slug)))
		{
			// Data is invalid, return FALSE;
			return FALSE;
		}
		
		// Retrieve the widgets
		if($widgets = $this->widgets->get_widgets(array('area_id' => $area->area_id)))
		{
			// Widgets exist, loop through each widget
			foreach($widgets as $widget)
			{
				// Load the widget
				$this->widget($widget->widget_slug, $widget->widget_id);
			}
		}
	}

}

/* End of file ClanCMS_Loader.php */
/* Location: ./clancms/core/ClanCMS_Loader.php */