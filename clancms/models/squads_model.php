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
 * Clan CMS Squads Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Squads_model extends Model {
	
	/**
	 * Constructor
	 *
	 */	
	function Squads_model()
	{
		// Call the Model constructor
		parent::Model();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Count Wins
	 *
	 * Counts's the number of wins a squad member has from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_wins($data = array())
	{
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Assign wins
		$wins = 0;
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('match_players');
		
		// Check if the query result exists
		if($query->result())
		{
			// Query results exists, loop through each row
			foreach($query->result() as $row)
			{
				// Retrieve the query2 from the database
				$query2 = $this->db
						->where('match_id', $row->match_id)
						->get('matches');
				
				// Check if query2 row is a win
				if($query2->row()->match_score > $query2->row()->match_opponent_score)
				{
					$wins++;
				}
			}
		}
						
		// Return the wins
		return $wins;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Losses
	 *
	 * Counts's the number of losses a squad member has from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_losses($data = array())
	{
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Assign losses
		$losses = 0;
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('match_players');
		
		// Check if the query result exists
		if($query->result())
		{
			// Query results exists, loop through each row
			foreach($query->result() as $row)
			{
				// Retrieve the query2 from the database
				$query2 = $this->db
						->where('match_id', $row->match_id)
						->get('matches');
				
				// Check if query2 row is a win
				if($query2->row()->match_score < $query2->row()->match_opponent_score)
				{
					$losses++;
				}
			}
		}
						
		// Return the losses
		return $losses;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Ties
	 *
	 * Counts's the number of ties a squad member has from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_ties($data = array())
	{
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Assign ties
		$ties = 0;
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('match_players');
		
		// Check if the query result exists
		if($query->result())
		{
			// Query results exists, loop through each row
			foreach($query->result() as $row)
			{
				// Retrieve the query2 from the database
				$query2 = $this->db
						->where('match_id', $row->match_id)
						->get('matches');
				
				// Check if query2 row is a win
				if($query2->row()->match_score == $query2->row()->match_opponent_score)
				{
					$ties++;
				}
			}
		}
						
		// Return the ties
		return $ties;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Kills
	 *
	 * Counts's the number of kills a squad member has from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_kills($data = array())
	{
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Assign kills
		$kills = 0;
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('match_players');
		
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, loop through each row
			foreach($query->result() as $row)
			{
				// Assign kills
				$kills += $row->player_kills;
			}
		}	
		
		// Return kills
		return $kills;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Count Deaths
	 *
	 * Counts's the number of deaths a squad member has from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_deaths($data = array())
	{
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Assign deaths
		$deaths = 0;
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('match_players');
				
		// Check if query result exists
		if($query->result())
		{
			// Query result exists, loop through each row
			foreach($query->result() as $row)
			{
				// Assign deaths
				$deaths += $row->player_deaths;
			}
		}		
		
		// Return deaths
		return $deaths;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Member
	 *
	 * Retrieves a squad member from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_member($data = array())
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
						->get('squad_members', 1);
		
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
	 * Get Members
	 *
	 * Retrieves all squad members from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_members($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('member_priority', 'asc')
						->where($data)
						->get('squad_members');
		
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
	 * Count Members
	 *
	 * Count the number of squad members in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_members($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('squad_members')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Member
	 *
	 * Inserts a squad member into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_member($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('squad_members', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Member
	 *
	 * Updates a squad member in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_member($member_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($member_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if member exists
		if(!$member = $this->get_member(array('member_id' => $member_id)))
		{
			// Member doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, member exists, update the data in the database
		return $this->db->update('squad_members', $data, array('member_id' => $member_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Member
	 *
	 * Deletes a squad member from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_member($member_id = 0)
	{	
		// Check to see if we have valid data
		if($member_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if member exists
		if(!$member = $this->get_member(array('member_id' => $member_id)))
		{
			// Member doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, member exists, delete the data from the database
		return $this->db->delete('squad_members', array('member_id' => $member_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Squad
	 *
	 * Retrieves a squad from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_squad($data = array())
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
						->get('squads', 1);
		
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
	 * Get Squads
	 *
	 * Retrieves all squads from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_squads($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('squad_priority', 'asc')
						->where($data)
						->get('squads');
		
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
	 * Count Squads
	 *
	 * Count the number of squads in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_squads($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('squads')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Squad
	 *
	 * Inserts a squad into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_squad($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('squads', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Squad
	 *
	 * Updates a squad in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_squad($squad_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($squad_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if squad exists
		if(!$squad = $this->get_squad(array('squad_id' => $squad_id)))
		{
			// Squad doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, squad exists, update the data in the database
		return $this->db->update('squads', $data, array('squad_id' => $squad_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Squad
	 *
	 * Deletes a squad from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_squad($squad_id = 0)
	{	
		// Check to see if we have valid data
		if($squad_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if squad exists
		if(!$squad = $this->get_squad(array('squad_id' => $squad_id)))
		{
			// Squad doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, squad exists, delete the data from the database
		return $this->db->delete('squads', array('squad_id' => $squad_id));
	}
}

/* End of file squads_model.php */
/* Location: ./clancms/models/squads_model.php */