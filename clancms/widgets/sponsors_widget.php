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
 * Clan CMS Sponsors Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Sponsors_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Sponsors_widget()
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
	 * Display's the sponsors
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Sponsors model
		$this->CI->load->model('Sponsors_model', 'sponsors');
		
		// Retrieve the sponsors
		$sponsors = $this->CI->sponsors->get_sponsors();
		
		// Create a reference to sponsors
		$this->data->sponsors =& $sponsors;
		
		// Load the sponsors widget view
		$this->CI->load->view(THEME . 'widgets/sponsors', $this->data);
	}
	
}
	
/* End of file sponsors_widget.php */
/* Location: ./clancms/widgets/sponsors_widget.php */