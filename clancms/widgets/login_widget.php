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
 * Clan CMS Login Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Login_widget extends Widget {

	// Widget information
	public $title = 'Login';
	public $description = "Display's the users login status and links for their account.";
	public $author = 'Xcel Gaming';
	public $link = 'http://www.xcelgaming.com';
	public $version = '1.0.0';
	
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
	 * Display's the login
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the user
		$user = $this->CI->users->get_user(array('user_id' => $this->CI->session->userdata('user_id')));
		
		// Create a reference to user
		$this->data->user = $user;
		
		// Assign the widget info
		$widget->title = '';
		$widget->content = $this->CI->load->view('widgets/login', $this->data, TRUE);
		
		// Check if the user is logged in
		if($this->CI->user->logged_in())
		{
			$widget->tabs = array(
				array(
					'title'		=> 'MY ACCOUNT',
					'link'		=> 'account',
					'selected'	=> TRUE
				),
				array(
					'title'		=> 'LOGOUT',
					'link'		=> 'account/logout',
					'selected'	=> FALSE
				)
			);
		}
		else
		{
			$widget->tabs = array(
				array(
					'title'		=> 'LOGIN',
					'link'		=> 'account/login',
					'selected'	=> TRUE
				),
				array(
					'title'		=> 'REGISTER',
					'link'		=> 'register',
					'selected'	=> FALSE
				)
			);
		}
			
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
			APPPATH . 'views/widgets/login.php'
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
	
/* End of file login_widget.php */
/* Location: ./clancms/widgets/login_widget.php */