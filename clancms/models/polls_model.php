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
 * @since		Version 0.5.5
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Polls Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Polls_model extends Model {
	
	/**
	 * Constructor
	 *
	 */	
	function Polls_model()
	{
		// Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Poll
	 *
	 * Retrieves a poll from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_poll($data = array())
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
						->get('polls', 1);
		
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
	 * Get Polls
	 *
	 * Retrieves all polls from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_polls($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('poll_id', 'asc')
						->where($data)
						->get('polls');
		
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
	 * Count Polls
	 *
	 * Count the number of polls in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_polls($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('polls')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Poll
	 *
	 * Inserts a poll into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_poll($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('polls', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Poll
	 *
	 * Updates a poll in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_poll($poll_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($poll_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if poll exists
		if(!$poll = $this->get_poll(array('poll_id' => $poll_id)))
		{
			// Poll doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, poll exists, update the data in the database
		return $this->db->update('polls', $data, array('poll_id' => $poll_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Poll
	 *
	 * Deletes a poll from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_poll($poll_id = 0)
	{	
		// Check to see if we have valid data
		if($poll_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if poll exists
		if(!$poll = $this->get_poll(array('poll_id' => $poll_id)))
		{
			// Poll doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, poll exists, delete the data from the database
		return $this->db->delete('polls', array('poll_id' => $poll_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Option
	 *
	 * Retrieves a poll option from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_option($data = array())
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
						->get('poll_options', 1);
		
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
	 * Get Options
	 *
	 * Retrieves all poll options from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_options($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('option_priority', 'asc')
						->where($data)
						->get('poll_options');
		
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
	 * Count Options
	 *
	 * Count the number of poll options in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_options($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('poll_options')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Option
	 *
	 * Inserts a poll option into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_option($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('poll_options', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Option
	 *
	 * Updates a poll option in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_option($option_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($option_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if option exists
		if(!$option = $this->get_option(array('option_id' => $option_id)))
		{
			// Option doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, option exists, update the data in the database
		return $this->db->update('poll_options', $data, array('option_id' => $option_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Option
	 *
	 * Deletes a poll option from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_option($option_id = 0)
	{	
		// Check to see if we have valid data
		if($option_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if option exists
		if(!$option = $this->get_option(array('option_id' => $option_id)))
		{
			// Option doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, option exists, delete the data from the database
		return $this->db->delete('poll_options', array('option_id' => $option_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Vote
	 *
	 * Retrieves a poll vote from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_vote($data = array())
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
						->get('poll_votes', 1);
		
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
	 * Get Votes
	 *
	 * Retrieves all poll votes from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_votes($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('vote_id', 'asc')
						->where($data)
						->get('poll_votes');
		
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
	 * Count Votes
	 *
	 * Count the number of poll votes in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_votes($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('poll_votes')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Vote
	 *
	 * Inserts a poll vote into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_vote($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('poll_votes', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Vote
	 *
	 * Updates a poll vote in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_vote($vote_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($vote_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if vote exists
		if(!$vote = $this->get_vote(array('vote_id' => $vote_id)))
		{
			// Vote doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, vote exists, update the data in the database
		return $this->db->update('poll_votes', $data, array('vote_id' => $vote_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Vote
	 *
	 * Deletes a poll vote from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_vote($vote_id = 0)
	{	
		// Check to see if we have valid data
		if($vote_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if vote exists
		if(!$vote = $this->get_vote(array('vote_id' => $vote_id)))
		{
			// Vote doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, vote exists, delete the data from the database
		return $this->db->delete('poll_votes', array('vote_id' => $vote_id));
	}
	
}
/* End of file polls_model.php */
/* Location: ./clancms/models/polls_model.php */