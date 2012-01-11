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
 * Clan CMS Shouts Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category		Models
 * @author		co[dezyne]
 * @link			http://www.codezyne.me
 */
class Shouts_model extends CI_Model {

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
	 * Get Shouts
	 *
	 * Retrieves last shouts
	 *
	 * @access	public
	 * @return	void
	 */
	 function get_shouts($limit = 0, $offset = 0) 
	 {
			
		// Check if limit exists
		if($limit == 0)
		{
			// Limit doesn't exist, assign limit
			$limit = '';
		}
		
		// Query the database
		$query = $this->db
						->order_by('id', 'desc')
						->limit($limit, $offset)
						->get('shoutbox');
		
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
	 * Delete Comment
	 *
	 * Deletes a shout from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_shout($shout_id = 0)	
	{

		// Check to see if we have valid data
		if($shout_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if icon exists
		if(!$shout = $this->get_shout(array('id' => $shout_id)))
		{
			// shout doesn't exist, return FALSE
			return FALSE;
		}

		
		// Data is valid, header exists, delete the data from the database 
		return $query = $this->db->delete('shoutbox', array('id' => $shout_id));

	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Article
	 *
	 * Retrieves a shout from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_shout($data = array())
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
						->get('shoutbox', 1);
		
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
	 * Count Articles
	 *
	 * Count the number of shouts in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_shouts($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('shoutbox')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	

	

/* End of file shouts_model.php */
/* Location: ./clancms/models/shouts_model.php */
}