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
 * Clan CMS Thread Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Thread_model extends CI_Model {

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
	 * Get Reply
	 *
	 * Retrieves a thread reply from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_reply($data = array())
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
						->get('thread_reply', 1);
		
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
	 * Retrieves all thread replies from the database
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
						->order_by('reply_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('thread_reply');
		
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
	 * Count the number of thread replies in the database
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
						->from('thread_reply')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Reply
	 *
	 * Inserts a thread reply into the database
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
		return $this->db->insert('thread_reply', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Reply
	 *
	 * Updates a thread reply in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_reply($reply_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($reply_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if reply exists
		if(!$reply = $this->get_reply(array('reply_id' => $reply_id)))
		{
			// Reply doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, reply exists, update the data in the database
		return $this->db->update('thread_reply', $data, array('reply_id' => $reply_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Reply
	 *
	 * Deletes a thread reply from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_reply($reply_id = 0)
	{	
		// Check to see if we have valid data
		if($reply_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if reply exists
		if(!$reply = $this->get_reply(array('reply_id' => $reply_id)))
		{
			// Reply doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, reply exists, delete the data from the database
		return $this->db->delete('thread_reply', array('reply_id' => $reply_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Thread
	 *
	 * Retrieves a thread from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_thread($data = array())
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
						->get('threads', 1);
		
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
	 * Get Threads
	 *
	 * Retrieves all threads from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_threads($limit = 0, $offset = 0, $data = array())
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
						->order_by('thread_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('threads');
		
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
	 * Count Threads
	 *
	 * Count the number of threads in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_threads($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('threads')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Thread
	 *
	 * Inserts a thread into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_thread($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('thread', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Thread
	 *
	 * Updates a thread in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_thread($thread_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($thread_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if thread exists
		if(!$thread = $this->get_article(array('thread_id' => $thread_id)))
		{
			// Thread doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, article exists, update the data in the database
		return $this->db->update('threads', $data, array('thread_id' => $thread_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Thread
	 *
	 * Deletes a thread from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_thread($thread_id = 0)
	{	
		// Check to see if we have valid data
		if($article_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if article exists
		if(!$article = $this->get_thread(array('thread_id' => $thread_id)))
		{
			// Article doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, article exists, delete the data from the database
		return $this->db->delete('thread', array('thread_id' => $thread_id));
	}
	
}

/* End of file thread_model.php */
/* Location: ./clancms/models/thread_model.php */