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
 * Clan CMS Unzip Class
 *
 * @package		Clan CMS
 * @subpackage	Libraries
 * @category	Unzip
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Unzip {

	var $CI;
	
	/**
	 * Constructor
	 *
	 */	
	function Unzip()
	{	
		// Create an instance to CI
		$this->CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Extract
	 *
	 * Extract a zip file
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	function extract($file, $destination)
	{
		// Check if the file exists
		if(file_exists($file) === TRUE)
		{
			// Check if destination exists
			if(!$destination)
			{
				// Destination doesn't exist, assign destination
				$destination = dirname($file);
			}
		
			// Create a new zip archive
			$zip = new ZipArchive();

			// Open the zip
			if($zip->open($file) === TRUE)
			{
				// Extract the zip
				$zip->extractTo($destination);
			}

			// Close the zip
			return $zip->close();
		}
		
		// Return FALSE
		return FALSE;
	}
	
}

/* End of file Unzip.php */
/* Location: ./clancms/libraries/Unzip.php */