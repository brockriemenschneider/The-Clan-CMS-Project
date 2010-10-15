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
 * @since		Version 0.5.3
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Users Online Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Users_Online_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Users_Online_widget()
	{
		// Call the Widget constructor
		parent::Widget();
		
		// Create a instance to CI
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the users online
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the users
		$users = $this->CI->users->get_users();
		
		// Assign users online
		$users_online = '';
		
		// Check if users exist
		if($users)
		{
			// Assign online count
			$online_count = 1;
			
			// Users exist, loop through each user
			foreach($users as $user)
			{
				// Check if the user is online
				if($this->CI->user->is_online($user->user_id))
				{
					// Check if online count is 1
					if($online_count == 1)
					{
						// Online count is 1, add the user to users online
						$users_online.= anchor('account/profile/' . $this->CI->users->user_slug($user->user_name), $user->user_name);
					}
					else
					{
						// Online count is greater than 1, add the user to users online
						$users_online.= ', ' . anchor('account/profile/' . $this->CI->users->user_slug($user->user_name), $user->user_name);
					}
					
					// Increment online count
					$online_count++;
				}
			}
		}
		
		// Retreive the total users that are online
		$this->data->total_users_online = $this->CI->users->users_online();
		
		// Retrieve the total guests that are online
		$this->data->total_guests_online = $this->CI->users->guests_online();
		
		// Create a reference to users online
		$this->data->users_online =& $users_online;
	
		// Load the admin cp users online widget view
		$this->CI->load->view(ADMINCP . 'widgets/users_online', $this->data);
	}
	
}
	
/* End of file users_online_widget.php */
/* Location: ./clancms/widgets/admincp/users_online_widget.php */