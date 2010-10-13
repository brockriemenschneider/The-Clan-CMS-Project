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
 * Clan CMS Widget Class
 *
 * @package		Clan CMS
 * @subpackage	Libraries
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Widget {

	var $CI;
	
	/**
	 * Constructor
	 *
	 */	
	function Widget()
	{	
		// Create an instance to CI
		$this->CI =& get_instance();
		
		// Call the widget index
		$this->index();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * The widget's index
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// By default this does nothing
	}
	
}

/* End of file Widget.php */
/* Location: ./clancms/libraries/Widget.php */