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
 * @since		Version 0.5.3
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Update Class
 *
 * @package		Clan CMS
 * @subpackage  Libraries
 * @category    Update
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Update {

	var $CI;
	
	/**
	 * Constructor
	 *
	 */	
	function Update()
	{	
		// Create an instance to CI
		$this->CI =& get_instance();
	}
					
	// --------------------------------------------------------------------
	
    /**
	 * Install
	 *
	 * Installs the update
	 *
	 * @access	public
     * @return	bool
	 */
    function install()
    {
		
	}
	
	// --------------------------------------------------------------------
	
	 /**
	 * Self Destruct
	 *
	 * Destroys the the update package
	 *
	 * @access	public
     * @return	void
	 */
	function self_destruct()
	{
		// Define the path to the update package
		$update_files = array(
			'./clancms/libraries/Update.php'
		);
	
		// Loop through the update files
		foreach($update_files as $update_file)
		{
			// Delete the update file
			unlink($update_file);
		}
	}
	
}

/* End of file Update.php */
/* Location: ./clancms/libraries/Update.php */