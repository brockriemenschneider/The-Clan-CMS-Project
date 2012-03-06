<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright		Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link			http://www.xcelgaming.com
 * @since			Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Tracker Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category		Models
 * @author		co[dezyne]
 * @link			http://codezyne.me
 */
class Tracker_model extends CI_Model {

	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	// ----------------------------------------------------------------------------
	/**
	 * Track
	 *
	 * Tracks a user's view history
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	 function track($data = array())
	{
		// Check to see if we have valid data
		if(empty($data) OR !is_associative($data))
		{
			// Data is invalid, return FALSE
			return FALSE;
		}
		
		// Data is valid, insert the data in the database
		return $this->db->insert('tracker', $data);
	 }
	 
	 // ----------------------------------------------------------------------------
	/**
	 * Check
	 *
	 * Checks if user has previously viewed object
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	 function check($data = array())
	{
		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('tracker', 1);
		
		// Check if query row exists
		if($query->row())
		{
			// Query row exists, return query row
			return $query->row();
		}
		else
		{
			// Query row doesn't exist, return FALSE
			return FALSE;
		}
	}
	
	 // ----------------------------------------------------------------------------
	/**
	 * Get_new
	 *
	 * Checks all objects in controller that are new to user
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 *
	 */
	 function get_new($controller, $slug, $user)
	{
		// Setup the data
		$data = array(
			'controller_name'	=>	$controller,
			'controller_item_id'	=>	$slug,
			'user_id'			=>	$user,
			);
		
		// Retrieve the query from the database
		$query = $this->db
					->where($data)
					->get('tracker', 1);
					
		// Check if query row exists
		if($query->row())
		{
			return $tracked = 1;
		}
		else {
			return FALSE;
		}
			
	}
	 
}
/* End of file tracker_model.php */
/* Location: ./clancms/models/tracker_model.php */