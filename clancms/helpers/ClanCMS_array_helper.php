<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright   Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link		http://www.xcelgaming.com
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Array Helper
 *
 * @package		Clan CMS
 * @subpackage  Helpers
 * @category    Helpers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
 
// --------------------------------------------------------------------
	
/**
* Is Associative
*
* Check if an array is an associative array
*
* @access	public
* @param	array
* @return	bool
*/
if ( ! function_exists('is_associative'))
{
	function is_associative($array = array())
	{
		// Check if the array is an array, make sure it's not empty, and count array keys to make sure its associative
		return (is_array($array) && (count($array)==0 || 0 !== count(array_diff_key($array, array_keys(array_keys($array))) )));
	} 
}

/* End of file ClanCMS_array_helper.php */
/* Location: ./clancms/helpers/ClanCMS_array_helper.php */