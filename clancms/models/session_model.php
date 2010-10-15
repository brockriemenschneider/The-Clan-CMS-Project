<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright	Copyright (c) 2010, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/license.php
 * @link		http://www.xcelgaming.com
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Session Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Session_model extends Model {

	/**
	 * Constructor
	 *
	 */	
	function Session_model()
	{
		// Call the Model constructor
		parent::Model();
		
		// Load the encryption library
		$this->load->library('encrypt');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Logout
	 *
	 * Destroys a user's session
	 *
	 * @access	public
	 * @return	void
	 */
	 
	function logout()
	{	
		// Delete cookies
		delete_cookie('user_id');
		delete_cookie('username');
		delete_cookie('password');
		
		// Destroy our session
		$this->session->set_userdata('user_id', '');
		$this->session->set_userdata('username', '');
		$this->session->set_userdata('password', '');
	}
	
	// --------------------------------------------------------------------

	/**
	 * Login
	 *
	 * Create's a user's session
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function login($username = '', $password = '', $remember = '')
	{	
		// Check to see if we have valid data
		if($username == '' OR $password == '')
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Create the password
		$password = $this->encrypt->sha1($this->users->get_user(array('user_name' => $username))->user_salt . $this->encrypt->sha1($password));
		
		// Setup the data
		$data = array(
			'user_name' 		=> $username,
			'user_password' 	=> $password,
			'user_activation' 	=> '1'
		);
		
		// Retrieve the user
		$user = $this->users->get_user($data);
	
		// Check if query exists
		if($user)
		{
			// Check if the user wants to be remembered
			if(isset($remember))
			{
				// Remember the user
				set_cookie('username', $this->encrypt->sha1($this->input->post('username')), '31536000');
				set_cookie('password', $password, '31536000');
			}
			
			// User exists, create the session data, return TRUE
			$this->session->set_userdata('user_id', $user->user_id);
			$this->session->set_userdata('username', $user->user_name);
			$this->session->set_userdata('password', $user->user_password);
			return TRUE;
		}
		else
		{
			// User doesn't exist, return FALSE
			return FALSE;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Logged In
	 *
	 * Check's to see if a user is logged in
	 *
	 * @access	public
	 * @return	bool
	 */
	function logged_in()
	{	
		// Check to see if their is session data
		if(!$this->session->userdata('username') OR !$this->session->userdata('password'))
		{
			// Sessions data doesn't exist, return FALSE
			return FALSE;
		}
		
		// Setup our data
		$data = array(
			'user_id'			=> $this->session->userdata('user_id'),
			'user_name'			=> $this->session->userdata('username'),
			'user_password'		=> $this->session->userdata('password'),
			'user_activation'	=> 1
		);
		
		// Check to see if user exists
		if($this->users->get_user($data))
		{
			// User exists, return TRUE
			return TRUE;
		}
		else
		{
			// User doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Is Remembered
	 *
	 * Check's to see if a user is remembered, if they are log them in
	 *
	 * @access	public
	 * @return	bool
	 */
	function is_remembered()
	{	
		// Check to see if the user is logged in
		if(!$this->logged_in())
		{
			return FALSE;
		}
		
		// Setup the data
		$data = array(
			'user_name'			=> $this->encrypt->sha1(get_cookie('username')),
			'user_password'		=> get_cookie('password'),
			'user_activation'	=> 1
		);
	
		// Retrieve the user
		$user = $this->users->get_user($data);
					
		// Check to see if user exists
		if($user)
		{
			// User exists, set the userdata, return TRUE
			$this->session->set_userdata('user_id', $user->row()->user_id);
			$this->session->set_userdata('username', $user->row()->user_name);
			$this->session->set_userdata('password', $password);
			return TRUE;
		}
		else
		{
			// User doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Is Online
	 *
	 * Returns the user's online status
	 *
	 * @access	public
	 * @param	int
	 * @return	bool
	 */
	function is_online($user_id = 0)
	{
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
			
			// Check if the session this user id
			if($user['user_id'] == $user_id)
			{
				// Session has this user id, return TRUE
				return TRUE;
			}
		}
		
		// User was not found, return FALSE;
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Is Administrator
	 *
	 * Check's to see if a user is an admin
	 *
	 * @access	public
	 * @return	bool
	 */
	function is_administrator()
	{
		// Check if user is logged in
		if(!$this->logged_in())
		{
			// User isn't logged in, return FALSE
			return FALSE;
		}
		
		// Check if user exists
		if(!$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id'))))
		{
			// User doesn't exist, return FALSE;
			return FALSE;
		}
		
		// Check if group exists
		if(!$group = $this->users->get_group(array('group_id' => $user->group_id)))
		{
			// Group doesn't exist, return FALSE;
			return FALSE;
		}
		
		// Return the group administrator as a boolean
		return (bool) $group->group_administrator;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Is Banned
	 *
	 * Check's to see if a user is banned
	 *
	 * @access	public
	 * @return	bool
	 */
	function is_banned()
	{
		// Check if user is logged in
		if(!$this->logged_in())
		{
			// User isn't logged in, return FALSE
			return FALSE;
		}
		
		// Check if user exists
		if(!$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id'))))
		{
			// User doesn't exist, return FALSE;
			return FALSE;
		}
		
		// Check if group exists
		if(!$group = $this->users->get_group(array('group_id' => $user->group_id)))
		{
			// Group doesn't exist, return FALSE;
			return FALSE;
		}
		
		// Return the group administrator as a boolean
		return (bool) $group->group_banned;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Has Permission
	 *
	 * Check's to see if a user has permission
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function has_permission($permission_slug = '')
	{	
		// Check to see if we have valid permission
		if($permission_slug == '')
		{
			// Permission is invalid, return FALSE
			return FALSE;
		}
		
		// Check if the user exists
		if(!$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id'))))
		{
			// User doesn't exist, return FALSE
			return FALSE;
		}
		
		// Check if the user group exists
		if(!$group = $this->users->get_group(array('group_id' => $user->group_id)))
		{
			// User group doesn't exist, return FALSE
			return FALSE;
		}

		// Assign permission total
		$permission_total = $group->group_permissions;
						
		// Check if the permissions exists
		if(!$permissions = $this->users->get_permissions())
		{
			// Permissions don't exist, return FALSE
			return FALSE;
		}
		 
		// Permissions exist, loop through each permission
		foreach($permissions as $permission)
		{
			// Check if the permision has a value less then the permission total
			if($permission->permission_value <= $permission_total)
			{
				// The permission value is less then the permission total, check if the permission is the one we are looking for
				if($permission->permission_slug == $permission_slug)
				{
					// Permission is the one we are looking for, return TRUE
					return TRUE;
				}
					
				// Calculate the new permission total
				$permission_total -= $permission->permission_value;
			}
		}
		
		// Permission was not found, return FALSE
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Salt
	 *
	 * Creates a random string of characters
	 *
	 * @access	private
	 * @param	int
	 * @return	string
	 */
	function _salt($length = 32)
	{
		// Load the string helper
		$this->load->helper('string');
		
		// Return the random string
		return random_string('alnum', $length);
	}
	
}

/* End of file session_model.php */
/* Location: ./clancms/models/session_model.php */