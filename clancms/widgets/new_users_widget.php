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
 * @since		Version 0.5.4
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
class New_Users_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function New_Users_widget()
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
	 * Display's the new users
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the text helper
		$this->CI->load->helper('text');
		
		// Retrieve the new users
		$new_users = $this->CI->users->get_users(9);
		
		// Create a reference to new users
		$this->data->new_users =& $new_users;
		
		// Load the users widget view
		$this->CI->load->view(THEME . 'widgets/new_users', $this->data);
	}
	
}
	
/* End of file new_users_widget.php */
/* Location: ./clancms/widgets/new_users_widget.php */