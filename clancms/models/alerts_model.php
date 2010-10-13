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
 * Clan CMS Alerts Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Alerts_model extends Model {
	
	/**
	 * Constructor
	 *
	 */	
	function Alerts_model()
	{
		// Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Alert
	 *
	 * Retrieves a alert from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_alert($data = array())
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
						->get('alerts', 1);
		
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
	 * Get Alerts
	 *
	 * Retrieves all alerts from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_alerts($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}

		// Retrieve the query from the database
		$query = $this->db
						->order_by('alert_id', 'desc')
						->where($data)
						->get('alerts');
		
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
	 * Count Alerts
	 *
	 * Count the number of alerts in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_alerts($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('alerts')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Alert
	 *
	 * Inserts a alert into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_alert($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('alerts', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Alert
	 *
	 * Updates a alert in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_alert($alert_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($alert_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if alert exists
		if(!$alert = $this->get_alert(array('alert_id' => $alert_id)))
		{
			// Alert doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, alert exists, update the data in the database
		return $this->db->update('alerts', $data, array('alert_id' => $alert_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Alert
	 *
	 * Deletes a alert from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_alert($alert_id = 0)
	{	
		// Check to see if we have valid data
		if($alert_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if alert exists
		if(!$alert = $this->get_alert(array('alert_id' => $alert_id)))
		{
			// Alert doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, alert exists, delete the data from the database
		return $this->db->delete('alerts', array('alert_id' => $alert_id));
	}
}

/* End of file alerts_model.php */
/* Location: ./clancms/models/alerts_model.php */