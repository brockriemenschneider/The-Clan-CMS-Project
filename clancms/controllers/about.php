<?php
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
 * Clan CMS About Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class About extends Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function About()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the typography library
		$this->load->library('typography');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the about page
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve about us, format html, create links & assign about
		$about = auto_link($this->typography->auto_typography($this->ClanCMS->get_setting('about_us')));
		
		// Create a reference to about
		$this->data->about =& $about;
		
		// Load the about view
		$this->load->view(THEME . 'about', $this->data);
	}
	
}

/* End of file about.php */
/* Location: ./clancms/controllers/about.php */