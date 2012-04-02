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
 * Clan CMS Users Online Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Users_Online_widget extends Widget {

	// Widget information
	public $title = 'Users Online';
	public $description = "Display's the users that are currently logged in and how many guests are on your site.";
	public $author = 'Xcel Gaming';
	public $link = 'http://www.xcelgaming.com';
	public $version = '1.0.0';
	
	// Widget Settings
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
	 * Display's the users online
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the users
		if($users = $this->CI->users->get_users())
		{
			// Assign users online
			$users_online = '';
		
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
	
		// Assign the widget info
		$widget->title = 'Users Online: ' . number_format($this->CI->users->users_online() + $this->CI->users->guests_online());
		$widget->content = $this->CI->load->view('widgets/users_online', $this->data, TRUE);
		$widget->tabs = array();
		
		// Load the widget view
		$this->CI->load->view(WIDGET . 'widget', $widget);
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
			APPPATH . 'views/widgets/users_online.php'
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
	
/* End of file users_online_widget.php */
/* Location: ./clancms/widgets/users_online_widget.php */