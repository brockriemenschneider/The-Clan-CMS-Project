<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright		Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link			http://www.xcelgaming.com
 * @since			Version 0.6.2
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Events Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category		Models
 * @author		co[dezyne]
 * @link			http://www.codezyne.me
 */
class Events_model extends CI_Model {

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
	 * Get event
	 *
	 * Retrieves a event from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_event($data = array())
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
						->get('events', 1);
		
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
	 * Get events
	 *
	 * Retrieves all events from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_events($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('event_day', 'asc')
						->where($data)
						->get('events');
		
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
	 * Count events
	 *
	 * Count the number of events in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_events($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('events')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert event
	 *
	 * Inserts a event into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_event($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('events', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update event
	 *
	 * Updates a event in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_event($event_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($event_id == 0 OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if event exists
		if(!$event = $this->get_event(array('event_id' => $event_id)))
		{
			// event doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, event exists, update the data in the database
		return $this->db->update('events', $data, array('event_id' => $event_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete event
	 *
	 * Deletes a event from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_event($event_id = 0)
	{	
		// Check to see if we have valid data
		if($event_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if event exists
		if(!$event = $this->get_event(array('event_id' => $event_id)))
		{
			// event doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, event exists, delete the data from the database
		return $this->db->delete('events', array('event_id' => $event_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Option
	 *
	 * Retrieves a event option from the database
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
						->get('event_options', 1);
		
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
	 * Retrieves all event options from the database
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
						->get('event_options');
		
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
	 * Count the number of event options in the database
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
						->from('event_options')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Option
	 *
	 * Inserts a event option into the database
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
		return $this->db->insert('event_options', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Option
	 *
	 * Updates a event option in the database
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
		return $this->db->update('event_options', $data, array('option_id' => $option_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Option
	 *
	 * Deletes a event option from the database
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
		return $this->db->delete('event_options', array('option_id' => $option_id));
	}
	

	
	// --------------------------------------------------------------------
	
	/**
	 * Get Votes
	 *
	 * Retrieves all event votes from the database
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
						->get('event_votes');
		
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
	 * Count the number of event votes in the database
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
						->from('event_votes')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Vote
	 *
	 * Inserts a event vote into the database
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
		return $this->db->insert('event_votes', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Vote
	 *
	 * Updates a event vote in the database
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
		return $this->db->update('event_votes', $data, array('vote_id' => $vote_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Vote
	 *
	 * Deletes a event vote from the database
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
		return $this->db->delete('event_votes', array('vote_id' => $vote_id));
	}
	
}
/* End of file events_model.php */
/* Location: ./clancms/models/events_model.php */