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
 * Clan CMS Sponsors Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Sponsors extends Controller {

	/**
	 * Constructor
	 *
	 */	
	function Sponsors()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the Sponsors model
		$this->load->model('Sponsors_model', 'sponsors');
		
		// Load the typography library
		$this->load->library('typography');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the sponsors
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve sponsors
		$sponsors = $this->sponsors->get_sponsors();
		
		// Check if sponsors exist
		if($sponsors)
		{
			// Sponsors exist, loop through each sponsor
			foreach($sponsors as $sponsor)
			{
				// Format html, create links & assign sponsor description
				$sponsor->sponsor_description = auto_link($this->typography->auto_typography($sponsor->sponsor_description));
			}
		}
		
		// Create a reference to sponsors
		$this->data->sponsors =& $sponsors;
		
		// Load the sponsors view
		$this->load->view(THEME . 'sponsors', $this->data);
	}
	
}

/* End of file sponsors.php */
/* Location: ./clancms/controllers/sponsors.php */