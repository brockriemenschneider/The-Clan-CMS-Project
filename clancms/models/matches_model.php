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
 * Clan CMS Matches Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Matches_model extends Model {
	
	/**
	 * Constructor
	 *
	 */	
	function Matches_model()
	{
		// Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Comment
	 *
	 * Retrieves a match comment from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_comment($data = array())
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
						->get('match_comments', 1);
		
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
	 * Get Comments
	 *
	 * Retrieves all match comments from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_comments($limit = 0, $offset = 0, $data = array())
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
						->order_by('comment_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('match_comments');
		
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
	 * Count Comments
	 *
	 * Count the number of match comments in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_comments($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('match_comments')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Comment
	 *
	 * Inserts a match comment into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_comment($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('match_comments', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Comment
	 *
	 * Updates a match comment in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_comment($comment_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($comment_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if comment exists
		if(!$comment = $this->get_comment(array('comment_id' => $comment_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, comment exists, update the data in the database
		return $this->db->update('match_comments', $data, array('comment_id' => $comment_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Comment
	 *
	 * Deletes a match comment from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_comment($comment_id = 0)
	{	
		// Check to see if we have valid data
		if($comment_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if comment exists
		if(!$comment = $this->get_comment(array('comment_id' => $comment_id)))
		{
			// Comment doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, comment exists, delete the data from the database
		return $this->db->delete('match_comments', array('comment_id' => $comment_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Player
	 *
	 * Retrieves a match player from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_player($data = array())
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
						->get('match_players', 1);
		
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
	 * Get Players
	 *
	 * Retrieves all match players from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_players($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('player_id', 'asc')
						->where($data)
						->get('match_players');
		
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
	 * Count Players
	 *
	 * Count the number of match players in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_players($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('match_players')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Player
	 *
	 * Inserts a match player into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_player($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('match_players', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Player
	 *
	 * Updates a match player in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_player($player_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($player_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if player exists
		if(!$player = $this->get_player(array('player_id' => $player_id)))
		{
			// Player doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, player exists, update the data in the database
		return $this->db->update('match_players', $data, array('player_id' => $player_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Player
	 *
	 * Deletes a match player from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_player($player_id = 0)
	{	
		// Check to see if we have valid data
		if($player_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if player exists
		if(!$player = $this->get_player(array('player_id' => $player_id)))
		{
			// Player doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, player exists, delete the data from the database
		return $this->db->delete('match_players', array('player_id' => $player_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Match
	 *
	 * Retrieves a match from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_match($data = array())
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
						->get('matches', 1);
		
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
	 * Get Matches
	 *
	 * Retrieves all matches from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_matches($limit = 0, $offset = 0, $data = array())
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
						->order_by('match_date', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('matches');
		
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
	 * Count Matches
	 *
	 * Count the number of matches in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_matches($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('matches')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Match
	 *
	 * Inserts a match into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_match($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('matches', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Match
	 *
	 * Updates a match in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_match($match_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($match_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if match exists
		if(!$match = $this->get_match(array('match_id' => $match_id)))
		{
			// Match doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, match exists, update the data in the database
		return $this->db->update('matches', $data, array('match_id' => $match_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Match
	 *
	 * Deletes a match from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_match($match_id = 0)
	{	
		// Check to see if we have valid data
		if($match_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if match exists
		if(!$match = $this->get_match(array('match_id' => $match_id)))
		{
			// Match doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, match exists, delete the data from the database
		return $this->db->delete('matches', array('match_id' => $match_id));
	}
}

/* End of file matches_model.php */
/* Location: ./clancms/models/matches_model.php */