<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
 * Clan CMS Settings Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Settings_model extends Model {
	
	/**
	 * Constructor
	 *
	 */	
	function Settings_model()
	{
		// Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Category
	 *
	 * Retrieves a setting category from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_category($data = array())
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
						->get('setting_categories', 1);
		
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
	 * Get Categories
	 *
	 * Retrieves all setting categories from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_categories($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('category_priority', 'asc')
						->where($data)
						->get('setting_categories');
		
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
	 * Count Categories
	 *
	 * Count the number of setting categories in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_categories($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('setting_categories')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Category
	 *
	 * Inserts a setting category into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_category($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('setting_categories', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Category
	 *
	 * Updates a setting category in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_category($category_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($category_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if category exists
		if(!$category = $this->get_category(array('category_id' => $category_id)))
		{
			// Category doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, category exists, update the data in the database
		return $this->db->update('setting_categories', $data, array('category_id' => $category_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Category
	 *
	 * Deletes a setting category from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_category($category_id = 0)
	{	
		// Check to see if we have valid data
		if($category_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if category exists
		if(!$category = $this->get_category(array('category_id' => $category_id)))
		{
			// Category doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, category exists, delete the data from the database
		return $this->db->delete('setting_categories', array('category_id' => $category_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Setting
	 *
	 * Retrieves a setting from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_setting($data = array())
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
						->get('settings', 1);
		
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
	 * Get Settings
	 *
	 * Retrieves all settings from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_settings($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('setting_priority', 'asc')
						->where($data)
						->get('settings');
		
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
	 * Count Settings
	 *
	 * Count the number of settings in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_settings($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('settings')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Setting
	 *
	 * Inserts a setting into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_setting($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('settings', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Setting
	 *
	 * Updates a setting in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_setting($setting_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($setting_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if setting exists
		if(!$setting = $this->get_setting(array('setting_id' => $setting_id)))
		{
			// Setting doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, setting exists, update the data in the database
		return $this->db->update('settings', $data, array('setting_id' => $setting_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Setting
	 *
	 * Deletes a setting from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_setting($setting_id = 0)
	{	
		// Check to see if we have valid data
		if($setting_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if setting exists
		if(!$setting = $this->get_setting(array('setting_id' => $setting_id)))
		{
			// Setting doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, setting exists, delete the data from the database
		return $this->db->delete('settings', array('setting_id' => $setting_id));
	}
}

/* End of file settings_model.php */
/* Location: ./clancms/models/settings_model.php */