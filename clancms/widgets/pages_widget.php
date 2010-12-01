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
 * Clan CMS Pages Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Pages_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Pages_widget()
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
	 * Display's the pages
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Pages model
		$this->CI->load->model('Pages_model', 'pages');
		
		// Retrieve the pages
		$pages = $this->CI->pages->get_pages();
		
		// Create a reference to pages
		$this->data->pages =& $pages;
		
		// Load the pages widget view
		$this->CI->load->view(THEME . 'widgets/pages', $this->data);
	}
	
}
	
/* End of file pages_widget.php */
/* Location: ./clancms/widgets/pages_widget.php */