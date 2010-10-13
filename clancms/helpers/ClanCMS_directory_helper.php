<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright   Copyright (c) 2010, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link		http://www.xcelgaming.com
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Directory Helper
 *
 * @package		Clan CMS
 * @subpackage  Helpers
 * @category    Helpers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
 
// --------------------------------------------------------------------
	
/**
* Delete Directory
*
* Delete's a directory and it's subdirectories
*
* @access	public
* @param	string
* @return	bool
*/
if ( ! function_exists('delete_directory'))
{
	function delete_directory($directory)
	{
		// Retrieve all of the files
		$files = glob($directory . '*', GLOB_MARK); 
		
		// Check if files exist
		if($files)
		{
			// Files exist, loop through each file
			foreach($files as $file)
			{ 
				// Check if file is a folder
				if( substr( $file, -1 ) == '/' ) 
				{
					// File is a folder, delete the folder
					delete_directory($file); 
				}
				else 
				{
					// File is a file, delete the file
					unlink($file);
				}
			}
		}
		
		// Check if the directory exists
		if (is_dir($directory))
		{
			// Directory exists, remove the directory
			rmdir($directory);
			
			// Return TRUE
			return TRUE;
		}
		else
		{
			// Directory doesn't exist, return FALSE
			return FALSE;
		}
	}
}

/* End of file ClanCMS_directory_helper.php */
/* Location: ./clancms/helpers/ClanCMS_directory_helper.php */