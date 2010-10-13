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
 * Clan CMS Sponsors Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Sponsors_model extends Model {
	
	/**
	 * Constructor
	 *
	 */	
	function Sponsors_model()
	{
		// Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Sponsor
	 *
	 * Retrieves a sponsor from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_sponsor($data = array())
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
						->get('sponsors', 1);
		
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
	 * Get Sponsors
	 *
	 * Retrieves all sponsors from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_sponsors($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('sponsor_priority', 'asc')
						->where($data)
						->get('sponsors');
		
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
	 * Count Sponsors
	 *
	 * Count the number of sponsors in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_sponsors($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('sponsors')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Sponsor
	 *
	 * Inserts a sponsor into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_sponsor($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('sponsors', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Sponsor
	 *
	 * Updates a sponsor in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_sponsor($sponsor_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($sponsor_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if sponsor exists
		if(!$sponsor = $this->get_sponsor(array('sponsor_id' => $sponsor_id)))
		{
			// Sponsor doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, sponsor exists, update the data in the database
		return $this->db->update('sponsors', $data, array('sponsor_id' => $sponsor_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Sponsor
	 *
	 * Deletes a sponsor from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_sponsor($sponsor_id = 0)
	{	
		// Check to see if we have valid data
		if($sponsor_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if sponsor exists
		if(!$sponsor = $this->get_sponsor(array('sponsor_id' => $sponsor_id)))
		{
			// Sponsor doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, sponsor exists, delete the data from the database
		return $this->db->delete('sponsors', array('sponsor_id' => $sponsor_id));
	}
}

/* End of file sponsors_model.php */
/* Location: ./clancms/models/sponsors_model.php */