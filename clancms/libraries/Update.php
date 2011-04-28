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

	public $CI;
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
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
		
		// Check if we need to update to 0.5.6
		if(CLANCMS_VERSION < '0.5.6')
		{
			// Update to 0.5.6
			$this->update_056();
		}
		
		// Check if we need to update to 0.6.0
		if(CLANCMS_VERSION < '0.6.0')
		{
			// Update to 0.6.0
			$this->update_060();
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
		
		// Add squad slug column to the squads table in the database
		$this->CI->dbforge->add_column('squads', $fields, 'squad_slug');

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
			'category_title'	=> 'Registration Settings',
			'category_priority'	=> '4'
		);
		
		// Insert the setting category into the database
		$this->CI->settings->insert_category($data);
		
		// Get the registration settings setting category id
		$registration_setting_id = $this->CI->db->insert_id();
		
		// Set up the data
		$data = array(
			'category_id'			=> $registration_setting_id,
			'setting_title'			=> 'Allow Registration',
			'setting_slug'			=> 'allow_registration',
			'setting_value'			=> '1',
			'setting_type'			=> 'dropdown',
			'setting_description'	=> 'Allow users to register on the site?',
			'setting_priority'		=> '1'
		);
		
		// Insert the setting into the database
		$this->CI->settings->insert_setting($data);
		
		// Set up the data
		$data = array(
			'category_id'			=> $registration_setting_id,
			'setting_title'			=> 'CAPTCHA Words',
			'setting_slug'			=> 'captcha_words',
			'setting_value'			=> 'Xcel Gaming',
			'setting_type'			=> 'textarea',
			'setting_description'	=> 'Word Bank for CAPTCHA. Seperate each word on a new line.',
			'setting_priority'		=> '2'
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
		
		// Load the Users model
		$this->CI->load->model('Users_model', 'users');
		
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
		
		// Load the Squads model
		$this->CI->load->model('Squads_model', 'squads');
		
		// Retrieve the squads
		if($squads = $this->CI->squads->get_squads())
		{
			// Squads exist, loop through each squad
			foreach($squads as $squad)
			{
				// Set up the data
				$data = array(
					'squad_status'		=> '1'
				);
			
				// Update the squad in the database
				$this->CI->squads->update_squad($squad->squad_id, $data);
			}
		}
	}
	
	// --------------------------------------------------------------------
	
    /**
	 * update_056
	 *
	 * Update for v0.5.6
	 *
	 * @access	public
     * @return	bool
	 */
    function update_056()
    {
		// Old files
		$old_files = array(
			'./clancms/controllers/about.php',
			'./clancms/views/themes/default/about.php',
			'./clancms/views/themes/default/images/box_pages.png',
			'./clancms/views/admincp/images/box_pages.png'
		);
		
		// Loop through each old file
		foreach($old_files as $old_file)
		{
			// Check if the file exists
			if(file_exists($old_file))
			{
				// File exists, delete the old file
				unlink($old_file);
			}
		}
		
		// Set up the fields
		$fields = array(
			'opponent_id' => array(
								'type' 				=> 'BIGINT',
								'constraint'		=> '20',
								'auto_increment'	=> TRUE
							),
			'opponent_title' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'opponent_slug' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'opponent_link' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'opponent_tag' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							)
		);
		
		// Add the fields
		$this->CI->dbforge->add_field($fields);
		
		// Add a key to opponent id
		$this->CI->dbforge->add_key('opponent_id');
		
		// Create the opponents table in the database
		$this->CI->dbforge->create_table('match_opponents');
		
		// Load the Users model
		$this->CI->load->model('Users_model', 'users');
		
		// Set up the data
		$data = array(
			'permission_title'		=> 'Can manage opponents?',
			'permission_slug'		=> 'opponents',
			'permission_value'		=> '512'
		);
		
		// Insert the permission into the database
		$this->CI->users->insert_permission($data);
		
		// Retrieve the administrators user group
		if($group = $this->CI->users->get_group(array('group_id' => '2')))
		{
			// Set up the data
			$data = array(
				'group_permissions'		=> '1023'
			);
			
			// Update the administrators user group in the database
			$this->CI->users->update_group($group->group_id, $data);
		}
		
		// Set up the fields
		$fields = array(
			'opponent_id' => array(
								'type' 			=> 'BIGINT',
								'constraint' 	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add opponent id column to the matches table in the database
		$this->CI->dbforge->add_column('matches', $fields, 'match_slug');
		
		// Set up the fields
		$fields = array(
			'match_maps' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							)
		);
		
		// Add match maps column to the matches table in the database
		$this->CI->dbforge->add_column('matches', $fields, 'match_opponent_score');
		
		// Load the Matches model
		$this->CI->load->model('Matches_model', 'matches');
		
		// Retrieve the matches
		if($matches = $this->CI->matches->get_matches())
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Retrieve the opponent
				$opponent = $this->CI->matches->get_opponent(array('opponent_title' => $match->match_opponent));
				
				// Check if the opponent exists
				if($opponent)
				{
					// Set up our data
					$data = array (
						'opponent_id'			=> $opponent->opponent_id
					);
		
					// Update the match into the database
					$this->CI->matches->update_match($match->match_id, $data);
				}
				else
				{
					// Set up the data
					$data = array (
						'opponent_title'	=> $match->match_opponent,
						'opponent_link'		=> $match->match_opponent_link,
						'opponent_tag'		=> ''
					);
			
					// Insert the opponent into the database
					$this->CI->matches->insert_opponent($data);
					
					// Retrieve the opponent id
					$opponent_id = $this->CI->db->insert_id();
				
					// Set up our data
					$data = array (
						'opponent_slug'		=> $opponent_id . '-' . url_title($match->match_opponent)
					);
				
					// Update the opponent into the database
					$this->CI->matches->update_opponent($opponent_id, $data);
				
					// Set up our data
					$data = array (
						'opponent_id'			=> $opponent_id
					);
		
					// Update the match into the database
					$this->CI->matches->update_match($match->match_id, $data);
				}
			}
		}
		
		// Drop depricated matches columns
		$this->CI->dbforge->drop_column('matches', 'match_opponent');
		$this->CI->dbforge->drop_column('matches', 'match_opponent_link');
		
		// Set up the fields
		$fields = array(
			'squad_tag' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE,
							),
			'squad_tag_position' => array(
								'type' 			=> 'TINYINT',
								'constraint' 	=> '1',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add squad tag, squad tag position columns to the squads table in the database
		$this->CI->dbforge->add_column('squads', $fields, 'squad_slug');
	}
	
	// --------------------------------------------------------------------
	
    /**
	 * update_060
	 *
	 * Update for v0.6.0
	 *
	 * @access	public
     * @return	bool
	 */
    function update_060()
    {		
        // Fetch the config file
        $config_file = read_file('./clancms/views/install/update/0.6.0/config.php');
		
		// Determine if mod rewrite works
		if(file_get_contents(base_url() . 'install/modrewrite') == 1)
		{
			$index = '""';
		}
		else
		{
			$index = '"index.php"';
		}
		
        // Variables to replace
        $replace = array(
            '"index.php"' => $index,
			'__ENCRYPTION__' => $this->CI->user->_salt(),
            '$config[\'sess_use_database\'] = FALSE;' => '$config[\'sess_use_database\'] = TRUE;'
        );
		
        // Create the new config file content
        $new_config_file = str_replace(array_keys($replace), $replace, $config_file);
			
		// Attempt to write to the config file
		@chmod('./clancms/config/config.php', 0666);
        write_file('./clancms/config/config.php', $new_config_file, 'w+');
		
		// Fetch the .htaccess file
        $htaccess_file = read_file('./clancms/views/install/update/0.6.0/htaccess.txt');
		
		// Attempt to write to the .htaccess file
		@chmod('.htaccess', 0666);
        write_file('.htaccess', $htaccess_file, 'w+');
		
		// Fetch the database file
        $db_file = read_file('./clancms/config/database.php');
		
		// Get the database info
		preg_match_all('/(\$db\[\'default\'\]\[\')(?P<name>.+)(\'\])(\s)=(\s)(\"|\')(?P<value>.+)(\"|\')/', $db_file, $matches);
		
        // Variables to replace
        $replace = array(
            '__DBPREFIX__' => $matches['value'][5],
            '__HOSTNAME__' => $matches['value'][0],
            '__USERNAME__' => $matches['value'][1],
            '__PASSWORD__' => $matches['value'][2],
            '__DATABASE__' => $matches['value'][3],
            '$db[\'default\'][\'autoinit\'] = FALSE;' => '',
			'__PORT__' => 3306
        );
		
        // Create the new database file content
        $new_db_file = str_replace(array_keys($replace), $replace, $db_file);
		
		// Attempt to write to the database file
		@chmod('./clancms/views/install/update/0.6.0/database.php', 0666);
        write_file('./clancms/views/install/update/0.6.0/database.php', $new_db_file, 'w+');
		
		// Old files
		$old_files = array(
			'./codeigniter/language/english/scaffolding_lang.php',
			'./codeigniter/language/english/validation_lang.php',
			'./codeigniter/libraries/Benchmark.php',
			'./codeigniter/libraries/Config.php',
			'./codeigniter/libraries/Controller.php',
			'./codeigniter/libraries/Exceptions.php',
			'./codeigniter/libraries/Hooks.php',
			'./codeigniter/libraries/Input.php',
			'./codeigniter/libraries/Language.php',
			'./codeigniter/libraries/Loader.php',
			'./codeigniter/libraries/Model.php',
			'./codeigniter/libraries/Output.php',
			'./codeigniter/libraries/Router.php',
			'./codeigniter/libraries/URI.php',
			'./codeigniter/libraries/Validation.php'
		);
		
		// Loop through each old file
		foreach($old_files as $old_file)
		{
			// Check if the file exists
			if(file_exists($old_file))
			{
				// File exists, delete the old file
				unlink($old_file);
			}
		}
		
		// Old folders
		$old_folders = array(
			'./clancms/views/themes/default/widgets/',
			'./clancms/views/admincp/widgets/',
			'./clancms/widgets/admincp/',
			'./codeigniter/cache/',
			'./codeigniter/codeigniter/',
			'./codeigniter/logs/',
			'./codeigniter/plugins/',
			'./codeigniter/scaffolding/'
		);
		
		// Loop through each old folder
		foreach($old_folders as $old_folder)
		{
			// Delete the old folder
			delete_directory($old_folder);
		}
		
		// Set up the data
		$data = array(
			'permission_title'		=> 'Can manage widgets?',
			'permission_slug'		=> 'widgets',
			'permission_value'		=> '1024'
		);
		
		// Insert the permission into the database
		$this->CI->users->insert_permission($data);
		
		// Retrieve the administrators user group
		if($group = $this->CI->users->get_group(array('group_id' => '2')))
		{
			// Set up the data
			$data = array(
				'group_permissions'		=> '2047'
			);
			
			// Update the administrators user group in the database
			$this->CI->users->update_group($group->group_id, $data);
		}
		
		// Load the settings model
		$this->CI->load->model('Settings_model', 'settings');
		
		// Set up the fields
		$fields = array(
			'setting_type' => array(
								'type' 			=> 'ENUM',
								'constraint' 	=> "'text','timezone','select','textarea'",
								'null'			=> FALSE,
								'default'		=> 'text'
							)
		);
		
		// Modify setting type column in the settings table in the database
		$this->CI->dbforge->modify_column('settings', $fields);
		
		// Set up the fields
		$fields = array(
			'setting_options' => array(
								'type' 			=> 'TEXT',
								'null'			=> FALSE
							)
		);
		
		// Add setting options column to the settings table in the database
		$this->CI->dbforge->add_column('settings', $fields, 'setting_type');
		
		// Set up the fields
		$fields = array(
			'setting_rules' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							)
		);
		
		// Add setting rules column to the settings table in the database
		$this->CI->dbforge->add_column('settings', $fields, 'setting_description');
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '1')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'text',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim|required'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '2')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'text',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim|required'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '3')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'timezone',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim|required'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '4')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'text',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim|required|valid_email'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '5')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'select',
				'setting_options'	=> '1=Yes|0=No',
				'setting_rules'		=> 'trim|required'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '6')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'text',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '7')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'text',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '8')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'select',
				'setting_options'	=> '1=Yes|0=No|2=Text',
				'setting_rules'		=> 'trim|required'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '9')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'text',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim|required|numeric'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '10')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'select',
				'setting_options'	=> '1=Yes|0=No',
				'setting_rules'		=> 'trim|required'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Retrieve the setting
		if($setting = $this->CI->settings->get_setting(array('setting_id' => '11')))
		{
			// Set up the data
			$data = array(
				'setting_type'		=> 'textarea',
				'setting_options'	=> '',
				'setting_rules'		=> 'trim|required'
			);
			
			// Update the setting in the database
			$this->CI->settings->update_setting($setting->setting_id, $data);
		}
		
		// Set up the fields
		$fields = array(
			'widget_id' => array(
								'type' 				=> 'BIGINT',
								'constraint'		=> '20',
								'auto_increment'	=> TRUE
							),
			'area_id' => array(
								'type' 			=> 'BIGINT',
								'constraint'	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							),
			'widget_title' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'widget_slug' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'widget_settings' => array(
								'type' 			=> 'TEXT',
								'null'			=> FALSE
							),
			'widget_priority' => array(
								'type' 			=> 'BIGINT',
								'constraint' 	=> '20',
								'null'			=> FALSE,
								'default'		=> '0'
							)
		);
		
		// Add the fields
		$this->CI->dbforge->add_field($fields);
		
		// Add a key to widget id
		$this->CI->dbforge->add_key('widget_id');
		
		// Create the widgets table in the database
		$this->CI->dbforge->create_table('widgets');
		
		// Set up the data
		$data = array (
			'area_id'			=> '1',
			'widget_title'		=> 'Login',
			'widget_slug'		=> 'login',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '0'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '1',
			'widget_title'		=> 'Poll',
			'widget_slug'		=> 'polls',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '1'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '1',
			'widget_title'		=> 'Matches',
			'widget_slug'		=> 'matches',
			'widget_settings'	=> 'a:2:{s:12:"matches_type";s:1:"0";s:14:"matches_number";s:1:"5";}',
			'widget_priority'	=> '2'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '1',
			'widget_title'		=> 'Sponsors',
			'widget_slug'		=> 'sponsors',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '3'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '1',
			'widget_title'		=> 'Users Online',
			'widget_slug'		=> 'users_online',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '4'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '2',
			'widget_title'		=> 'Articles',
			'widget_slug'		=> 'articles',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '0'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '3',
			'widget_title'		=> 'Admin CP Login',
			'widget_slug'		=> 'login',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '0'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '3',
			'widget_title'		=> 'Site Stats',
			'widget_slug'		=> 'site_stats',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '1'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '3',
			'widget_title'		=> 'Admin CP Users Online',
			'widget_slug'		=> 'users_online',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '2'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '4',
			'widget_title'		=> 'Admin CP Alerts',
			'widget_slug'		=> 'administrator_alerts',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '0'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '5',
			'widget_title'		=> 'Pages',
			'widget_slug'		=> 'pages',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '0'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the data
		$data = array (
			'area_id'			=> '6',
			'widget_title'		=> 'New Users',
			'widget_slug'		=> 'new_users',
			'widget_settings'	=> 'b:0;',
			'widget_priority'	=> '0'
		);
			
		// Insert the widget into the database
		$this->CI->db->insert('widgets', $data);
		
		// Set up the fields
		$fields = array(
			'area_id' => array(
								'type' 				=> 'BIGINT',
								'constraint'		=> '20',
								'auto_increment'	=> TRUE
							),
			'area_title' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							),
			'area_slug' => array(
								'type' 			=> 'VARCHAR',
								'constraint' 	=> '200',
								'null'			=> FALSE
							)
		);
		
		// Add the fields
		$this->CI->dbforge->add_field($fields);
		
		// Add a key to area id
		$this->CI->dbforge->add_key('area_id');
		
		// Create the opponents table in the database
		$this->CI->dbforge->create_table('widget_areas');
		
		// Set up the data
		$data = array (
			'area_title'	=> 'Sidebar',
			'area_slug'		=> 'sidebar'
		);
			
		// Insert the widget area into the database
		$this->CI->db->insert('widget_areas', $data);
		
		// Set up the data
		$data = array (
			'area_title'	=> 'Header',
			'area_slug'		=> 'header'
		);
			
		// Insert the widget area into the database
		$this->CI->db->insert('widget_areas', $data);
		
		// Set up the data
		$data = array (
			'area_title'	=> 'Admin CP Sidebar',
			'area_slug'		=> 'admincp_sidebar'
		);
			
		// Insert the widget area into the database
		$this->CI->db->insert('widget_areas', $data);
		
		// Set up the data
		$data = array (
			'area_title'	=> 'Admin CP Header',
			'area_slug'		=> 'admincp_header'
		);
			
		// Insert the widget area into the database
		$this->CI->db->insert('widget_areas', $data);
		
		// Set up the data
		$data = array (
			'area_title'	=> 'Navigation',
			'area_slug'		=> 'navigation'
		);
			
		// Insert the widget area into the database
		$this->CI->db->insert('widget_areas', $data);
		
		// Set up the data
		$data = array (
			'area_title'	=> 'Dashboard',
			'area_slug'		=> 'dashboard'
		);
			
		// Insert the widget area into the database
		$this->CI->db->insert('widget_areas', $data);
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