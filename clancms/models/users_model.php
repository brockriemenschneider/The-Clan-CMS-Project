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
 * Clan CMS Users Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Users_model extends Model {
	
	/**
	 * Constructor
	 *
	 */	
	function Users_model()
	{
		// Call the Model constructor
		parent::Model();
	}
	
	// --------------------------------------------------------------------

	/**
	 * User Slug
	 *
	 * Converts a user name to a user slug
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function user_slug($user_name = '')
	{
		// Replace all spaces with +
		$user_slug = str_replace(' ', '+', $user_name);
		
		// Return the user slug
		return $user_slug;
	}
	
	// --------------------------------------------------------------------

	/**
	 * User Name
	 *
	 * Converts a user slug to a user name
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function user_name($user_slug = '')
	{
		// Replace all + with spaces
		$user_name = str_replace('+', ' ', $user_slug);
		
		// Return the user name
		return $user_name;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Guests Online
	 *
	 * Counts the number of guest sessions from the database
	 *
	 * @access	public
	 * @return	int
	 */
	function guests_online()
	{
		// Set online to 0
		$online = 0;
		
		// Retrieve the query from the database
		$query = $this->db
						->where(array('last_activity > ' => $this->session->now - $this->config->item('sess_time_to_update')))
						->order_by('last_activity', 'desc')
						->get('sessions');
		
		// Loop through each result
		foreach($query->result() as $row)
		{
			// Retrieve each result's data
			$custom_data = $this->session->_unserialize($row->user_data);

			// Loop through each data item and assign it to a variable
			foreach ($custom_data as $key => $val)
			{
				$guest[$key] = $val;
			}
			
			// Check if the session has a user id
			if($guest['user_id'] == "")
			{
				// Session doesn't have a user id so iterate online
				$online++;
			}
			
		}
		
		// Return online
		return $online;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Users Online
	 *
	 * Counts the number of user sessions from the database
	 *
	 * @access	public
	 * @return	int
	 */
	function users_online()
	{
		// Set online to 0
		$online = 0;
		
		// Set user ids as an empty array
		$user_ids = array();
		
		// Retrieve the query from the database
		$query = $this->db
						->where(array('last_activity > ' => $this->session->now - $this->config->item('sess_time_to_update')))
						->order_by('last_activity', 'desc')
						->get('sessions');
		
		// Loop through each result
		foreach($query->result() as $row)
		{
			// Retrieve each result's data
			$custom_data = $this->session->_unserialize($row->user_data);

			// Loop through each data item and assign it to a variable
			foreach ($custom_data as $key => $val)
			{
				$user[$key] = $val;
			}
			
			// Check if the session has a user id
			if($user['user_id'] != "")
			{
				if(!in_array($user['user_id'], $user_ids))
				{
					// Session has a user id so iterate online
					$online++;
					
					// Push the user id onto the user ids array
					array_push($user_ids, $user['user_id']);
				}
			}
			
		}
		
		// Return online
		return $online;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Permission
	 *
	 * Retrieves a group permission from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_permission($data = array())
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
						->get('group_permissions', 1);
		
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
	 * Get Permissions
	 *
	 * Retrieves all group permissions from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_permissions($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('permission_value', 'desc')
						->where($data)
						->get('group_permissions');
		
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
	 * Count Permissions
	 *
	 * Count the number of group permissions in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_permissions($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('group_permissions')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Permission
	 *
	 * Inserts a group permission into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_permission($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('group_permissions', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Permission
	 *
	 * Updates a group permission in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_permission($permission_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($permission_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if permission exists
		if(!$permission = $this->get_permission(array('permission_id' => $permission_id)))
		{
			// Permission doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, permission exists, update the data in the database
		return $this->db->update('group_permissions', $data, array('permission_id' => $permission_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Permission
	 *
	 * Deletes a group permission from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_permission($permission_id = 0)
	{	
		// Check to see if we have valid data
		if($permission_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if permission exists
		if(!$permission = $this->get_permission(array('permission_id' => $permission_id)))
		{
			// Permission doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, permission exists, delete the data from the database
		return $this->db->delete('group_permissions', array('permission_id' => $permission_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Group
	 *
	 * Retrieves a user group from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_group($data = array())
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
						->get('user_groups', 1);
		
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
	 * Get Groups
	 *
	 * Retrieves all user groups from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_groups($data = array())
	{
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->order_by('group_id', 'desc')
						->where($data)
						->get('user_groups');
		
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
	 * Count Groups
	 *
	 * Count the number of user groups in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_groups($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('user_groups')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert Group
	 *
	 * Inserts a user group into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_group($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('user_groups', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update Group
	 *
	 * Updates a user group in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_group($group_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($group_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if group exists
		if(!$group = $this->get_group(array('group_id' => $group_id)))
		{
			// Group doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, group exists, update the data in the database
		return $this->db->update('user_groups', $data, array('group_id' => $group_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete Group
	 *
	 * Deletes a user group from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_group($group_id = 0)
	{	
		// Check to see if we have valid data
		if($group_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if group exists
		if(!$group = $this->get_group(array('group_id' => $group_id)))
		{
			// Group doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, group exists, delete the data from the database
		return $this->db->delete('user_groups', array('group_id' => $group_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get User
	 *
	 * Retrieves a user from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_user($data = array())
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
						->get('users', 1);
		
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
	 * Get Users
	 *
	 * Retrieves all users from the database
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function get_users($limit = 0, $offset = 0, $data = array())
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
						->order_by('user_id', 'desc')
						->limit($limit, $offset)
						->where($data)
						->get('users');
		
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
	 * Count Users
	 *
	 * Count the number of users in the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function count_users($data = array())
	{	
		// Check for valid data
		if($data && !is_array($data) && !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->from('users')
						->where($data)
						->count_all_results();
						
		// Return query
		return $query;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert User
	 *
	 * Inserts a user into the database
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert_user($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('users', $data);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Update User
	 *
	 * Updates a user in the database
	 *
	 * @access	public
	 * @param	int
	 * @param	array
	 * @return	bool
	 */
	function update_user($user_id = 0, $data = array())
	{
		// Check to see if we have valid data
		if($user_id == '0' OR empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if user exists
		if(!$user = $this->get_user(array('user_id' => $user_id)))
		{
			// User doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, user exists, update the data in the database
		return $this->db->update('users', $data, array('user_id' => $user_id));
	}

	// --------------------------------------------------------------------
	
    /**
	 * Delete User
	 *
	 * Deletes a user from the database
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function delete_user($user_id = 0)
	{	
		// Check to see if we have valid data
		if($user_id == 0)
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Check if user exists
		if(!$user = $this->get_user(array('user_id' => $user_id)))
		{
			// User doesn't exist, return FALSE
			return FALSE;
		}
		
		// Data is valid, user exists, delete the data from the database
		return $this->db->delete('users', array('user_id' => $user_id));
	}
	
}

/* End of file users_model.php */
/* Location: ./clancms/models/users_model.php */