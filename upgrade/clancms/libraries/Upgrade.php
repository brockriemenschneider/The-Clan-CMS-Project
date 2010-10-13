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
 * @since		Version 0.5.2
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Upgrade Class
 *
 * @package		Clan CMS
 * @subpackage  Libraries
 * @category    Upgrade
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Upgrade {

	var $CI;
	
	/**
	 * Constructor
	 *
	 */	
	function Upgrade()
	{	
		// Create an instance to CI
		$this->CI =& get_instance();
	}
					
	// --------------------------------------------------------------------
	
    /**
	 * Install
	 *
	 * Installs the upgrade
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
	 * Destroys the the upgrade package
	 *
	 * @access	public
     * @return	void
	 */
	function self_destruct()
	{
		// Define the path to the upgrade package
		$upgrade_files = array(
			'./clancms/libraries/Upgrade.php'
		);
	
		// Delete the upgrade files
		foreach($upgrade_files as $files)
		{
			unlink($files);
		}
	}
	
}

/* End of file Upgrade.php */
/* Location: ./clancms/libraries/Upgrade.php */