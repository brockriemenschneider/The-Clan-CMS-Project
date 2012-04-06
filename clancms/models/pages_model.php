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
 * @since		Version 0.5.4
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Pages Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Pages_model extends CI_Model {

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
	 * Get Page
	 *
	 * Retrieves a page from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_page($data = array())
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
						->get('pages', 1);
		
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
	 * Get Pages
	 *
	 * Retrieves all pages from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_pages($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('page_priority', 'asc')
						->where($data)
						->get('pages');
		
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
	 * Count Pages
	 *
	 * Count the number of pages in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_pages($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('pages')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Page
	 *
	 * Inserts a page into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_page($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('pages', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Page
	 *
	 * Updates a page in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_page($page_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($page_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if page exists
		if(!$page = $this->get_page(array('page_id' => $page_id)))
		{
			// Page doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, page exists, update the data in the database
		return $this->db->update('pages', $data, array('page_id' => $page_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Page
	 *
	 * Deletes a page from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_page($page_id = 0)
	{	
		// Check to see if we have valid data
		if($page_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if page exists
		if(!$page = $this->get_page(array('page_id' => $page_id)))
		{
			// Page doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, page exists, delete the data from the database
		return $this->db->delete('pages', array('page_id' => $page_id));
	}
}

/* End of file pages_model.php */
/* Location: ./clancms/models/pages_model.php */