<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Clan CMS
 *
 * An open source application for gaming clans
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
 * Clan CMS Social Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category		Models
 * @author		co[dezyne]
 * @link			http://www.xcelgaming.com
 */
class Social_model extends CI_Model {

	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	// --------------------------------------------------------------------
	/**
	 * Get Games
	 *
	 * Retrieves game listings from the database
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	function get_social($uri) {
		$q = $this->db->get_where('user_extend', array('user' => $uri));
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
			    $data = $row;
			}
		return $data;
		}
		print_r($data);
		echo 'lalala';
	}	
	
	// --------------------------------------------------------------------
	/**
	 * Get User's social status
	 *
	 *  
	 *
	 * @access	public
	 * @param	array
	 * @return	array
	 */	
	function check_user($data = array()) {	

		// Check for valid data
		if(empty($data) OR !is_associative($data))
		{
			// Invalid data, return FALSE
			return FALSE;
		}
		
		// Retrieve the query from the database
		$query = $this->db
						->where($data)
						->get('user_extend', 1);
		
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
	// --------------------------------------------------------------------

	/**
	 * Update update_social
	 *
	 * Inserts social media info into db
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	 function update_social($data)
	 {
	 	// Check if user exists already
		if(!$update = $this->check_user(array('user' => $data['user'])))
		{
			// User doesn't exist, insert the record
			$this->db->insert('user_extend', $data);
		}else{
			// User needs to update
			$this->db->where('user', $data['user']);
			$this->db->update('user_extend', $data);
		}
	}

	
}

/* End of file users_model.php */
/* Location: ./clancms/models/users_model.php */