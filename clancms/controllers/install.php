<?php
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
 * Clan CMS Install Controller
 *
 * @package		Clan CMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Install extends Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function Install()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the Installer Library
		$this->load->library('Installer');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Displays Step 1 of the installation process
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Check if uri is correct
		if(uri_string() == '/install')
		{
			// Uri is incorrect, redirect the user
			redirect('../install/index');
		}
		
		// Welcome to Clan CMS, Step 1 passed
		$this->session->set_userdata('step_1_passed', TRUE);
						
		// Load Step 1
		$this->load->view('install/step1');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Step 2
	 *
	 * Displays Step 2 of the installation process
	 *
	 * @access	public
	 * @return	void
	 */
	function step2()
	{
		// Check to see that the user has passed previous steps
		if( ! $this->session->userdata('step_1_passed'))
		{
			// Redirect the user back to step 1
			redirect('../index');
		}
		
		// Set Form Validation Rules for DB info
        $this->form_validation->set_rules('dbprefix', 'Database Prefix', 'trim');
        $this->form_validation->set_rules('hostname', 'Database Host', 'trim|required');
        $this->form_validation->set_rules('database', 'Database Name', 'trim|required');
		$this->form_validation->set_rules('username', 'Database Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Database Password', 'trim');
		$this->form_validation->set_rules('create_database', '', '');
		
		// Assign the create database variable so we can check it
		$create_database = $this->input->post('create_database');
				
        // Clear and Intialize error data
        $this->session->set_userdata('error','');
				
		// Form validation passed, so continue with installation
		if (!$this->form_validation->run() == FALSE)
		{
			// Save DB info
            $this->session->set_userdata(array(
				'dbprefix' =>	$this->input->post('dbprefix'),
				'hostname' =>	$this->input->post('hostname'),
				'database' =>	$this->input->post('database'),
				'username' =>	$this->input->post('username'),
				'password' =>	$this->input->post('password')
            ));
		
			// Check to see if we can connect to the DB
            if($this->installer->test_db_connection())
            {
				// Create a connection
                $this->db = mysql_connect($this->session->userdata('hostname'), $this->session->userdata('username'), $this->session->userdata('password'));
				
                // User wants us to attempt to create the database
                if( !empty($create_database) )
                {
                    if (!mysql_query('CREATE DATABASE IF NOT EXISTS ' . $this->session->userdata('database'), $this->db))
                    {
						// Could not create the database, alert the user
                        $this->session->set_userdata('error', 'Could not create the database! Please do this yourself.');
                    }
                }
                else
                {
                    if( !mysql_select_db($this->session->userdata('database'), $this->db) )
                    {
						// Could not select the database, alert the user
                        $this->session->set_userdata('error', 'Could not select the database!');
                    }
                }
				
                // Close the connection
                mysql_close($this->db);
						
                // Check to see if database creation/selection failed
                if(!$this->session->userdata('error'))
                {
					// Attempt to write to the database file
					if($this->installer->write_db_file())
					{
						// Install the database
						$this->installer->install();
						
						// Database file was written, Step 2 passed
						$this->session->set_userdata('step_2_passed', TRUE);
						
						// Step 2 passed, Redirect to step 3
						redirect('../step3', 'refresh');
					}
					else
					{
						// Database file could not be written, alert the user
						$this->session->set_userdata('error', 'Could not write to the database file!');
					}
				}
			}
			else
			{
				// DB Connection failed, alert the user
                $this->session->set_userdata('error', 'Could not connect to the database!');
			}
		
		}
		
		// Load Step 2
		$this->load->view('install/step2');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Step 3
	 *
	 * Displays Step 3 of the installation process
	 *
	 * @access	public
	 * @return	void
	 */
	function step3()
	{
		// Check to see that the user has passed previous steps
		if( ! $this->session->userdata('step_2_passed'))
		{
			// Redirect the user back to step 2
			redirect('../step2');
		}
		
		// Set Form Validation Rules for Site Info
        $this->form_validation->set_rules('clan_name', 'Clan Name', 'trim|required');
        $this->form_validation->set_rules('site_link', 'Site Link', 'trim|required|prep_url');
        $this->form_validation->set_rules('site_email', 'Site Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('timezone', 'Default Timezone', 'trim|required');
		$this->form_validation->set_rules('daylight_savings', 'Daylight Savings', 'trim|required');
				
        // Clear and Intialize error data
        $this->session->set_userdata('error','');
				
		// Form validation passed, so continue with installation
		if (!$this->form_validation->run() == FALSE)
		{
			// Save Site info
            $this->session->set_userdata(array(
				'clan_name' 		=>	$this->input->post('clan_name'),
				'site_link' 		=>	$this->input->post('site_link'),
				'site_email'		=>	$this->input->post('site_email'),
				'timezone'			=>	$this->input->post('timezone'),
				'daylight_savings'	=>	$this->input->post('daylight_savings')
            ));
			
			// Update Required Site Settings
			$this->settings->update_setting(1, array('setting_value' => $this->session->userdata('clan_name')));
			$this->settings->update_setting(4, array('setting_value' => $this->session->userdata('site_email')));
			$this->settings->update_setting(3, array('setting_value' => $this->session->userdata('timezone')));
			$this->settings->update_setting(5, array('setting_value' => $this->session->userdata('daylight_savings')));
				
			// Site Settings configured, Step 3 passed
			$this->session->set_userdata('step_3_passed', TRUE);
					
			// Step 3 passed, Redirect to step 4
			redirect('../step4', 'refresh');
		}
		
		// Load Step 3
		$this->load->view('install/step3');
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Step 4
	 *
	 * Displays Step 4 of the installation process
	 *
	 * @access	public
	 * @return	void
	 */
	function step4()
	{
		// Check to see that the user has passed previous steps
		if(!$this->session->userdata('step_3_passed'))
		{
			// Redirect the user back to step 3
			redirect('../step3');
		}
				
		// Set Form Validation Rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback__alpha_dash_space');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
		$this->form_validation->set_rules('daylight_savings', 'Daylight Savings', 'trim|required');
				
		// Form validation passed, so continue with installation
		if (!$this->form_validation->run() == FALSE)
		{
			// Retrieve salt
			$salt = $this->user->_salt();
			
			// Set up the data
			$data = array(
				'group_id'					=> 2,
				'user_name'					=> $this->input->post('username'),
				'user_password'				=> $this->encrypt->sha1($salt . $this->encrypt->sha1($this->input->post('password'))),
				'user_salt'					=> $salt,
				'user_email'				=> $this->input->post('email'),
				'user_timezone'				=> $this->input->post('timezone'),
				'user_daylight_savings'		=> $this->input->post('daylight_savings'),
				'user_ipaddress'			=> $this->input->ip_address(),
				'user_activation'			=> 1,
				'user_joined'				=> mdate('%Y-%m-%d %H:%i:%s', now())
			);
			
			// Insert Our User
			$this->users->insert_user($data);
		
			// Account Registered, Step 4 passed
			$this->session->set_userdata('step_4_passed', TRUE);
					
			// Step 4 passed, Redirect to Completetion
			redirect('../complete', 'refresh');
		}
			
		// Load Step 4
		$this->load->view('install/step4');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Complete
	 *
	 * Displays the completetion of the installation process
	 *
	 * @access	public
	 * @return	void
	 */
	function complete()
	{
		// Check to see that the user has passed previous steps
		if( ! $this->session->userdata('step_4_passed'))
		{
			// Redirect the user back to step 4
			redirect('../step4');
		}
		
		// Attempt to write the config file
		$this->installer->write_config_file();
		
		// Write the ClanCMS file
		$this->installer->write_ClanCMS_file();
		
        // Load installation completetion
        $this->load->view('install/complete');

        // Destroy our session
        $this->session->sess_destroy();
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * Alpha Dash Space
	 *
	 * Check's to see if a username is valid
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _alpha_dash_space($user_name = '')
	{
		// Check if the user name is valid
		if(!preg_match("/^([-a-z0-9_ ])+$/i", $user_name))
		{
			// User name isn't valid, alert the user & return FALSE
			$this->form_validation->set_message('_alpha_dash_space', 'The username may only contain alpha-numeric characters, spaces, underscores, and dashes.');
			return FALSE;
		}
		else
		{
			// User name is valid, return TRUE
			return TRUE;
		}
	} 
}

/* End of file install.php */
/* Location: ./clancms/controllers/install.php */