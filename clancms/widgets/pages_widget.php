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
 * Clan CMS Pages Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Pages_widget extends Widget {

	// Widget information
	public $title = 'Pages';
	public $description = "Display's the custom pages for a menu to link to the pages.";
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
		$this->CI->load->view('widgets/pages', $this->data);
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
			APPPATH . 'views/widgets/pages.php'
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
	
/* End of file pages_widget.php */
/* Location: ./clancms/widgets/pages_widget.php */