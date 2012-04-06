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
 * @since		Version 0.6.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Widgets Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Widgets_model extends CI_Model {
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Widget Slug
	 *
	 * Retrieve's a widget's slug
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function widget_slug($widget_slug = '')
	{
		// Check if widget slug is valid
		if($widget_slug == '')
		{
			// return FALSE
			return FALSE;
		}

		// Load the xmlrpc library
		$this->load->library('xmlrpc');
		
		// Assign server and the method to be requested
		$this->xmlrpc->server('http://www.xcelgaming.com/widgets', 80);
		$this->xmlrpc->method('widget_slug');
		
		// Assign the request
		$request = array(
			array(
				'widget_slug' => array($widget_slug, 'string'),
			), 'struct');
		
		// Request the response
		$this->xmlrpc->request(array($request, 'array'));
		
		// Check if the xml rpc request failed
		if($this->xmlrpc->send_request())
		{
			// Return True
			return TRUE;
		}
		
		// return FALSE
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check updates
	 *
	 * Check's if a widget has an update
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	function check_updates($widget_slug = '')
	{
		// Retrieve the widget
		if(!$widget = $this->read_widget($widget_slug))
		{
			// Return FALSE
			return FALSE;
		}

		// Load the xmlrpc library
		$this->load->library('xmlrpc');
		
		// Assign server and the method to be requested
		$this->xmlrpc->server('http://www.xcelgaming.com/widgets', 80);
		$this->xmlrpc->method('update');
		
		// Assign the request
		$request = array(
			array(
				'widget_slug' => array($widget->slug, 'string'),
			), 'struct');
		
		// Request the response
		$this->xmlrpc->request(array($request, 'array'));
		
		// Check if the xml rpc request failed
		if($this->xmlrpc->send_request())
		{
			// Retrievethe response
			$response = $this->xmlrpc->display_response();
			$update = $response[0]['widget'];
			
			// Check if the versions are different
			if(version_compare($widget->version, $update['download_version'], '<'))
			{
				// Assign update
				$update = array(
					'title' 		=> $widget->title,
					'version'		=> $update['download_version'],
					'slug'			=> $widget->slug
				);
				
				// Return the update
				return $update;
			}
		}
		
		// return FALSE
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Is Installed
	 *
	 * Check's if a widget is installed
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function is_installed($widget_slug = '')
	{
		// Check if widget slug exists
		if($widget_slug == '')
		{
			// Return FALSE
			return FALSE;
		}
		
		// Retrieve all installed widgets
		$installed_widgets = $this->scan_widgets();
			
		// Loop through each installed widget
		foreach($installed_widgets as $installed_widget)
		{
			// Check if the widget is installed
			if($widget_slug == $installed_widget->slug)
			{
				// Return TRUE
				return TRUE;
			}
		}
		
		// Return FALSE
		return FALSE;
	}
	 
	// --------------------------------------------------------------------
	
	/**
	 * Read Widget
	 *
	 * Reads a widget
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	function read_widget($widget_slug = '')
	{
    	// Check if the widget exists
		if(file_exists(WIDGETS . $widget_slug . '_widget.php'))
		{
			// Include the widget
			include_once(WIDGETS . $widget_slug . '_widget.php');
		
			// Assign class name
			$class_name = ucfirst($widget_slug . '_widget');
			
			// Initiate the widget
			$widget = new $class_name;
			
			// Retrieve the widget information
			$widget = (object) get_object_vars($widget);
			
			// Assign slug
			$widget->slug = $widget_slug;
			
			// Return the widget
			return $widget;
		}
		else
		{
			// File doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Scan Widgets
	 *
	 * Scan's all available widgets
	 *
	 * @access	public
	 * @return	array
	 */
	function scan_widgets()
	{	
		// Assign available widgets
		$available_widgets = array();
		
		// Loop through the widget files
		foreach(glob(WIDGETS . '*_widget.php') as $widget_slug)
		{
			// Get the file name
			$widget_slug = basename($widget_slug, '_widget.php');
				
			// Widget is not activated, add the widget to deacivated widgets
			array_push($available_widgets, $this->read_widget($widget_slug));
		}
		
		// Return the available widgets
		return $available_widgets;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Area
	 *
	 * Retrieves a widget area from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_area($data = array())
	{	
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('widget_areas', 1);
		
		// Check if query row exists
		if($query->row())
		{
			// Query row exists, return query row
			return $query->row();
		}
		else
		{
			// Query row doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Areas
	 *
	 * Retrieves all widget areas from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_areas($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('area_id', 'desc')
						->where($data)
						->get('widget_areas');
		
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, return query result
			return $query->result();
		}
		else
		{
			// Query result doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Areas
	 *
	 * Count the number of widget areas in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_areas($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('widget_areas')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Area
	 *
	 * Inserts a widget area into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_area($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('widget_areas', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Area
	 *
	 * Updates a widget area in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_area($area_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($area_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if area exists
		if(!$area = $this->get_area(array('area_id' => $area_id)))
		{
			// Area doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, area exists, update the data in the database
		return $this->db->update('widget_areas', $data, array('area_id' => $area_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Area
	 *
	 * Deletes a widget area from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_area($area_id = 0)
	{	
		// Check to see if we have valid data
		if($area_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if area exists
		if(!$area = $this->get_area(array('area_id' => $area_id)))
		{
			// Area doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, area exists, delete the data from the database
		return $this->db->delete('widget_areas', array('area_id' => $area_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Widget
	 *
	 * Retrieves a widget from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_widget($data = array())
	{	
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('widgets', 1);
		
		// Check if query row exists
		if($query->row())
		{
			// Query row exists, return query row
			return $query->row();
		}
		else
		{
			// Query row doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Widgets
	 *
	 * Retrieves all widgets from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_widgets($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('widget_priority', 'asc')
						->where($data)
						->get('widgets');
		
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, return query result
			return $query->result();
		}
		else
		{
			// Query result doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Widgets
	 *
	 * Count the number of widgets in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_widgets($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('widgets')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Widget
	 *
	 * Inserts a widget into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_widget($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('widgets', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Widget
	 *
	 * Updates a widget in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_widget($widget_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($widget_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if widget exists
		if(!$widget = $this->get_widget(array('widget_id' => $widget_id)))
		{
			// Widget doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, widget exists, update the data in the database
		return $this->db->update('widgets', $data, array('widget_id' => $widget_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Widget
	 *
	 * Deletes a widget from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_widget($widget_id = 0)
	{	
		// Check to see if we have valid data
		if($widget_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if widget exists
		if(!$widget = $this->get_widget(array('widget_id' => $widget_id)))
		{
			// Widget doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, widget exists, delete the data from the database
		return $this->db->delete('widgets', array('widget_id' => $widget_id));
	}
}

/* End of file widgets_model.php */
/* Location: ./clancms/models/widgets_model.php */