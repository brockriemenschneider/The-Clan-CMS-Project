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
		
		// Load the file helper
		$this->CI->load->helper('file'); 
	
		// Load the directory helper
		$this->CI->load->helper('directory');
		
		// Load the database forge library
		$this->CI->load->dbforge();
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
		// Check if we need to update to 0.5.4
		if(CLANCMS_VERSION < '0.5.4')
		{
			// Update to 0.5.4
			$this->update_054();
		}
		
		// Check if we need to update to 0.5.5
		if(CLANCMS_VERSION < '0.5.5')
		{
			// Update to 0.5.5
			$this->update_055();
		}
	}
	
	// --------------------------------------------------------------------
	
    /**
	 * update_054
	 *
	 * Update for v0.5.4
	 *
	 * @access	public
     * @return	bool
	 */
    function update_054()
    {
		// Old files
		$old_files = array(
			'./clancms/views/themes/default/about.php',
			'./clancms/controllers/about.php',
			'./clancms/views/themes/default/message.php',
			'./clancms/views/admincp/message.php'
		);
		
		// Loop through each old file
		foreach($old_files as $old_file)
		{
			// Delete the old file
			unlink($old_file);
		}
		
		// Old folders
		$old_folders = array(
			'./clancms/views/admincp/css'
		);
		
		// Loop through each old folder
		foreach($old_folders as $old_folder)
		{
			// Delete the old folder
			delete_directory($old_folder);
		}
		
		// Retrieve all sponsor images
		if($sponsors = get_filenames('./clancms/views/images/'))
		{
			// Sponsors exist, loop through each sponsor
			foreach($sponsors as $sponsor)
			{
				// Copy the sponsor image
				copy('./clancms/views/images/' . $sponsor, './clancms/views/images/sponsors/' . $sponsor);
				
				// Delete the old sponsor image
				unlink('./clancms/views/images/' . $sponsor);
			}
		}
	
		// Set up the fields
		$fields = array(
			'user_avatar' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							)
		);
		
		// Add user avatar column to the users table in the database
		$this->CI->dbforge->add_column('users', $fields, 'user_joined');

		// Set up the fields
		$fields = array(
			'page_id' => array(
								'type' 				=> 'BIGINT',
								'constraint'		=> '20',
								'auto_increment'	=> TRUE
							),
			'page_title' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'page_slug' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'page_content' => array(
								'type' 			=> 'TEXT',
								'null'			=> FALSE
							),
			'page_priority' => array(
								'type' 			=> 'BIGINT',
								'constraint' 	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add the fields
		$this->CI->dbforge->add_field($fields);
		
		// Add a key to page id
		$this->CI->dbforge->add_key('page_id');
		
		// Create the pages table in the database
		$this->CI->dbforge->create_table('pages');
		
		// Load the Pages model
		$this->CI->load->model('Pages_model', 'pages');
		
		// Set up the data
		$data = array(
			'page_title'	=> 'About Us',
			'page_slug'		=> 'aboutus',
			'page_content'	=> $this->CI->ClanCMS->get_setting('about_us'),
			'page_priority'	=> '1'
		);
		
		// Insert the page into the database
		$this->CI->pages->insert_page($data);
		
		// Retrieve the about us setting
		if($setting = $this->CI->settings->get_setting(array('setting_slug' => 'about_us')))
		{
			// Delete the about us setting from the database
			$this->CI->settings->delete_setting($setting->setting_id);
		}
		
		// Retrieve the theme permission
		if($permission = $this->CI->users->get_permission(array('permission_value' => '128')))
		{
			// Delete the theme permission from the database
			$this->CI->users->delete_permission($permission->permission_id);
		}
		
		// Set up the data
		$data = array(
			'permission_title'		=> 'Can manage pages?',
			'permission_slug'		=> 'pages',
			'permission_value'		=> '128'
		);
		
		// Insert the permission into the database
		$this->CI->users->insert_permission($data);
		
		// Retrieve the administrators user group
		if($group = $this->CI->users->get_group(array('group_id' => '2')))
		{
			// Set up the data
			$data = array(
				'group_permissions'		=> '255'
			);
			
			// Update the administrators user group in the database
			$this->CI->users->update_group($group->group_id, $data);
		}
	}
	
	// --------------------------------------------------------------------
	
    /**
	 * update_055
	 *
	 * Update for v0.5.5
	 *
	 * @access	public
     * @return	bool
	 */
    function update_055()
    {
		// Set up the fields
		$fields = array(
			'squad_status' => array(
								'type' 			=> 'TINYINT',
								'constraint' 	=> '1',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add user avatar column to the squads table in the database
		$this->CI->dbforge->add_column('squads', $fields, 'squad_status');

		// Set up the fields
		$fields = array(
			'poll_id' => array(
								'type' 				=> 'BIGINT',
								'constraint'		=> '20',
								'auto_increment'	=> TRUE
							),
			'poll_title' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'poll_active' => array(
								'type' 			=> 'TINYINT',
								'constraint' 	=> '1',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add the fields
		$this->CI->dbforge->add_field($fields);
		
		// Add a key to poll id
		$this->CI->dbforge->add_key('poll_id');
		
		// Create the polls table in the database
		$this->CI->dbforge->create_table('polls');
		
		// Set up the fields
		$fields = array(
			'option_id' => array(
								'type' 				=> 'BIGINT',
								'constraint'		=> '20',
								'auto_increment'	=> TRUE
							),
			'poll_id' => array(
								'type' 			=> 'BIGINT',
								'constraint'	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							),
			'option_title' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'option_priority' => array(
								'type' 			=> 'BIGINT',
								'constraint' 	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add the fields
		$this->CI->dbforge->add_field($fields);
		
		// Add a key to option id
		$this->CI->dbforge->add_key('option_id');
		
		// Create the poll options table in the database
		$this->CI->dbforge->create_table('poll_options');
		
		// Set up the fields
		$fields = array(
			'vote_id' => array(
								'type' 				=> 'BIGINT',
								'constraint'		=> '20',
								'auto_increment'	=> TRUE
							),
			'poll_id' => array(
								'type' 			=> 'BIGINT',
								'constraint'	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							),
			'option_id' => array(
								'type' 			=> 'BIGINT',
								'constraint'	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							),
			'user_id' => array(
								'type' 			=> 'BIGINT',
								'constraint'	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add the fields
		$this->CI->dbforge->add_field($fields);
		
		// Add a key to vote id
		$this->CI->dbforge->add_key('vote_id');
		
		// Create the poll votes table in the database
		$this->CI->dbforge->create_table('poll_votes');
		
		// Load the Settings model
		$this->CI->load->model('Settings_model', 'settings');
		
		// Set up the data
		$data = array(
			'category_title'	=> 'Security',
			'category_priority'	=> '4'
		);
		
		// Insert the setting category into the database
		$this->CI->settings->insert_category($data);
		
		// Set up the data
		$data = array(
			'category_id'			=> $this->db->insert_id(),
			'setting_title'			=> 'CAPTCHA Words',
			'setting_slug'			=> 'captcha_words',
			'setting_value'			=> 'Xcel Gaming',
			'setting_type'			=> 'textarea',
			'setting_description'	=> 'Word Bank for CAPTCHA. Seperate each word on a new line.',
			'setting_priority'		=> '1'
		);
		
		// Insert the setting into the database
		$this->CI->settings->insert_setting($data);
		
		// Set up the data
		$data = array(
			'category_id'			=> '2',
			'setting_title'			=> 'Sponsor Image Width',
			'setting_slug'			=> 'sponsor_width',
			'setting_value'			=> '209',
			'setting_type'			=> 'input',
			'setting_description'	=> 'The width of sponsor images in pixels',
			'setting_priority'		=> '3'
		);
		
		// Insert the setting into the database
		$this->CI->settings->insert_setting($data);
		
		// Set up the data
		$data = array(
			'permission_title'		=> 'Can manage polls?',
			'permission_slug'		=> 'polls',
			'permission_value'		=> '256'
		);
		
		// Insert the permission into the database
		$this->CI->users->insert_permission($data);
		
		// Retrieve the administrators user group
		if($group = $this->CI->users->get_group(array('group_id' => '2')))
		{
			// Set up the data
			$data = array(
				'group_permissions'		=> '511'
			);
			
			// Update the administrators user group in the database
			$this->CI->users->update_group($group->group_id, $data);
		}
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