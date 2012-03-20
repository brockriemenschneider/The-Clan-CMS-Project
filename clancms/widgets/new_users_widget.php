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
 * @since		Version 0.6.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS New Users Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class New_users_widget extends Widget {

	// Widget information
	public $title = 'New Users';
	public $description = "Display's the new users that are in the clan.";
	public $author = 'Xcel Gaming';
	public $link = 'http://www.xcelgaming.com';
	public $version = '1.0.0';
	
	// Widget settings
	public $settings = array();
	
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Widget constructor
		parent::__construct();
		
		// Create a instance to CI
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the users
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the users
		if($users = $this->CI->users->get_users())
		{
			// Assign new users
			$new_users = array();
			
			// Assign users count
			$users_count = 0;
			
			// Users exist, loop through each user
			foreach($users as $user)
			{
				// Retrieve the users group
				if($group = $this->CI->users->get_group(array('group_id' => $user->group_id)))
				{
					// Check if the group is in the clan
					if((bool) $group->group_clan)
					{
						// Group is in the clan, check if users count is less then 10
						if($users_count < 10)
						{
							// Users count it less then 10, assign new users
							$new_users = array_merge($new_users, array($user));
						}
							
						// Itterate users count
						$users_count++;
					}
				}
	
			}	
		}
		
		// Create a reference to new users
		$this->data->new_users =& $new_users;
		
		// Load the articles widget view
		$this->CI->load->view('widgets/new_users', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * Uninstall's the widget
	 *
	 * @access	public
	 * @return	void
	 */
	function uninstall()
	{
		// Assign files
		$files = array(
			APPPATH . 'views/widgets/new_users.php'
		);
		
		// Loop through the files
		foreach($files as $file)
		{
			// Check if the file exists
			if(file_exists($file))
			{
				// Delete the file
				unlink($file);
			}
		}
		
		// Delete the widget
		unlink(__FILE__);
	}
	
}
	
/* End of file new_users_widget.php */
/* Location: ./clancms/widgets/new_users_widget.php */