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
 * @since		Version 0.6.2
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS PrivMsg Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class PrivMsg_model extends CI_Model {

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
	 * Get PrivMsg
	 *
	 * Retrieves a PM from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_privmsg($data = array())
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
						->get('privmsgs', 1);
		
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
	 * Get Replies
	 *
	 * Retrieves all PM replies from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_replies($limit = 0, $offset = 0, $data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Check if limit exists
		if($limit == 0)
		{
			// Limit doesn't exist, assign limit
			$limit = '';
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('msg_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('privmsgs');
		
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
	 * Count Replies
	 *
	 * Count the number of PM replies in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_replies($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('privmsgs')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Reply
	 *
	 * Inserts a PM reply into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_reply($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('privmsgs', $data);
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * Get privmsgs
	 *
	 * Retrieves all private messages from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_privmsgs($limit = 0, $offset = 0, $data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Check if limit exists
		if($limit == 0)
		{
			// Limit doesn't exist, assign limit
			$limit = '';
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('msg_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('privmsgs');
		
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
	 * Count Private Messages
	 *
	 * Count the number of private messages in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_privmsgs($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('privmsgs')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Private Message
	 *
	 * Inserts a private message into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_privmsg($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('privmsgs', $data);
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Private Message
	 *
	 * Deletes a private message from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_privmsg($msg_id = 0)
	{	
		// Check to see if we have valid data
		if($msg_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if pm exists
		if(!$privmsg = $this->get_privmsg(array('msg_id' => $msg_id)))
		{
			// privmsg doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, pm exists, delete the data from the database
		return $this->db->delete('privmsg', array('msg_id' => $msg_id));
	}
	
}

/* End of file privmsg_model.php */
/* Location: ./clancms/models/privmsg_model.php */