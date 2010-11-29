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
 * Clan CMS Login Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Login_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Login_widget()
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
		
		// Load the login widget view
		$this->CI->load->view(THEME . 'widgets/login', $this->data);
	}
	
}
	
/* End of file login_widget.php */
/* Location: ./clancms/widgets/login_widget.php */