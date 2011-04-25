<?php
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
 * Clan CMS Install Controller
 *
 * @package		Clan CMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Install extends CI_Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{
		// Call the Controller constructor
		parent::__construct();
		
		// Load the Installer Library
		$this->load->library('Installer');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Mod Rewrite
	 *
	 * A simple test to check for mod rewrite
	 *
	 * @access	public
	 * @return	void
	 */
	function modrewrite()
	{
		echo '1';
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
		// Retrieve the form
		$step2 = $this->input->post('step2');
		
		// Check if step 2 exists
		if($step2)
		{
			// Step 1 passed, Redirect to step 2
			redirect('install/step2');
		}
		else
		{
			// Welcome to Clan CMS, Step 1 passed
			$this->session->set_userdata('step_1_passed', TRUE);
							
			// Load Step 1
			$this->load->view('install/step1');
		}
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
			redirect('install/index');
		}
		
		// Set Form Validation Rules for DB info
        $this->form_validation->set_rules('db_prefix', 'Database Prefix', 'trim');
        $this->form_validation->set_rules('db_hostname', 'Database Host', 'trim|required');
        $this->form_validation->set_rules('db_port', 'Database Port', 'trim|required');
        $this->form_validation->set_rules('db_name', 'Database Name', 'trim|required');
		$this->form_validation->set_rules('db_username', 'Database Username', 'trim|required');
		$this->form_validation->set_rules('db_password', 'Database Password', 'trim');
		$this->form_validation->set_rules('create_database', '', '');
		
		// Assign the create database variable so we can check it
		$create_database = $this->input->post('create_database');
				
        // Clear and Intialize message data
        $this->session->set_userdata('message', '');
				
		// Form validation passed, so continue with installation
		if(!$this->form_validation->run() == FALSE)
		{
			// Save DB info
            $this->session->set_userdata(array(
				'db_prefix'   =>	$this->input->post('db_prefix'),
				'db_hostname' =>	$this->input->post('db_hostname'),
				'db_port' 	  =>	$this->input->post('db_port'),
				'db_name' 	  =>	$this->input->post('db_name'),
				'db_username' =>	$this->input->post('db_username'),
				'db_password' =>	$this->input->post('db_password')
            ));
			
			// Check to see if we can connect to the DB
            if($this->installer->test_db_connection())
            {
				// Create a connection
                $this->db = mysql_connect($this->session->userdata('db_hostname') . ':' . $this->session->userdata('db_port'), $this->session->userdata('db_username'), $this->session->userdata('db_password'));
				
				// Save DB info
				$this->session->set_userdata('server_version', @mysql_get_server_info($this->db));
				$this->session->set_userdata('client_version', preg_replace('/[^0-9\.]/','', mysql_get_client_info()));
				
                // User wants us to attempt to create the database
                if( !empty($create_database) )
                {
                    if (!mysql_query('CREATE DATABASE IF NOT EXISTS ' . $this->session->userdata('db_name'), $this->db))
                    {
						// Could not create the database, alert the user
                        $this->session->set_userdata('message', 'Could not create the database! Please do this yourself.');
                    }
                }
                else
                {
                    if( !mysql_select_db($this->session->userdata('db_name'), $this->db) )
                    {
						// Could not select the database, alert the user
                        $this->session->set_userdata('message', 'Could not select the database!');
                    }
                }
				
                // Close the connection
                mysql_close($this->db);
						
				// Check to see if we can continue
				if($this->session->userdata('message') == '')
				{
					// Database file was written, Step 2 passed
					$this->session->set_userdata('step_2_passed', TRUE);
							
					// Step 2 passed, Redirect to step 3
					redirect('install/step3');
				}
			}
			else
			{
				// DB Connection failed, alert the user
                $this->session->set_userdata('message', 'Could not connect to the database!');
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
			redirect('install/step2');
		}
		
		// Assign writeable directories
		$directories = array(
			'clancms/views/images',
			'clancms/views/images/avatars',
			'clancms/views/images/captcha',
			'clancms/views/images/sponsors'
		);
		
		// Assign writeable files
		$files = array(
			'clancms/config/config.php',
			'clancms/config/database.php',
			'clancms/models/clancms.php'
		);
		
		// Assign permissions
		$permissions = array();
		
		// Loop through each directory
		foreach($directories as $directory)
		{
			@chmod($directory, 0777);
			$permissions['directories'][$directory] = is_really_writable($directory);
		}
		
		// Loop through each file
		foreach($files as $file)
		{
			@chmod($file, 0666);
			$permissions['files'][$file] = is_really_writable($file);
		}
		
		// Clear and Intialize message data
        $this->session->set_userdata('message', '');
		
		// Retrieve the form
		$step4 = $this->input->post('step4');
		
		// Check if step 4 exists
		if($step4)
		{
			// Requirements checked, Step 3 passed
			$this->session->set_userdata('step_3_passed', TRUE);
			
			// Step 3 passed, Redirect to step 4
			redirect('install/step4');
		}
		else
		{
			// Clear and Intialize message data
			$this->session->set_userdata('message', '');
			
			// Assign the data
			$this->data->php_test = $this->installer->php_test();
			$this->data->php_version = $this->installer->php_version;
			$this->data->mysql_server_test = $this->installer->mysql_test('server');
			$this->data->mysql_server_version = $this->installer->mysql_server_version;
			$this->data->mysql_client_test = $this->installer->mysql_test('client');
			$this->data->mysql_client_version = $this->installer->mysql_client_version;
			$this->data->gd_test = $this->installer->gd_test();
			$this->data->gd_version = $this->installer->gd_version;
			$this->data->zlib_test = $this->installer->zlib_test();
			$this->data->disabled = FALSE;
			$this->data->directories = $directories;
			$this->data->files = $files;
			$this->data->permissions = $permissions;
			
			// Make sure the server meets the requirements
			if(!$this->installer->php_test() OR !$this->installer->mysql_test('server') OR !$this->installer->mysql_test('client') OR in_array(FALSE, $permissions['directories']) OR in_array(FALSE, $permissions['files']))
			{
				// Server doesn't meet the mandatory requirements, alert the user
				$this->data->disabled = TRUE;
				$this->session->set_userdata('message', 'Your server does not meet the mandatory requirements!');
			}
			
			// Load Step 3
			$this->load->view('install/step3', $this->data);
		}
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
		if( ! $this->session->userdata('step_3_passed'))
		{
			// Redirect the user back to step 3
			redirect('install/step3');
		}
		
		// Set Form Validation Rules for Site Info
        $this->form_validation->set_rules('clan_name', 'Clan Name', 'trim|required');
        $this->form_validation->set_rules('site_email', 'Site Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('timezone', 'Default Timezone', 'trim|required');
		$this->form_validation->set_rules('daylight_savings', 'Daylight Savings', 'trim|required');
				
        // Clear and Intialize message data
        $this->session->set_userdata('message','');
				
		// Form validation passed, so continue with installation
		if (!$this->form_validation->run() == FALSE)
		{
			// Save Site info
            $this->session->set_userdata(array(
				'clan_name' 		=>	$this->input->post('clan_name'),
				'site_email'		=>	$this->input->post('site_email'),
				'timezone'			=>	$this->input->post('timezone'),
				'daylight_savings'	=>	$this->input->post('daylight_savings')
            ));
				
			// Site Settings configured, Step 4 passed
			$this->session->set_userdata('step_4_passed', TRUE);
					
			// Step 4 passed, Redirect to step 5
			redirect('install/step5');
		}
		
		// Load Step 4
		$this->load->view('install/step4');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Step 5
	 *
	 * Displays Step 5 of the installation process
	 *
	 * @access	public
	 * @return	void
	 */
	function step5()
	{
		// Check to see that the user has passed previous steps
		if(!$this->session->userdata('step_4_passed'))
		{
			// Redirect the user back to step 4
			redirect('install/step4');
		}
				
		// Set Form Validation Rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback__alpha_dash_space');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('user_timezone', 'Timezone', 'trim|required');
		$this->form_validation->set_rules('user_daylight_savings', 'Daylight Savings', 'trim|required');
				
		// Form validation passed, so continue with installation
		if (!$this->form_validation->run() == FALSE)
		{
			// Save User info
            $this->session->set_userdata(array(
				'username' 				=>	$this->input->post('username'),
				'email'					=>	$this->input->post('email'),
				'password'				=>	$this->input->post('password'),
				'user_timezone'			=>	$this->input->post('user_timezone'),
				'user_daylight_savings'	=>	$this->input->post('user_daylight_savings'),
				'ipaddress'				=>	$this->input->ip_address()
            ));
			
			// Account Registered, Step 5 passed
			$this->session->set_userdata('step_5_passed', TRUE);
					
			// Step 5 passed, Redirect to Completetion
			redirect('install/complete');
		}
		
		// Load Step 5
		$this->load->view('install/step5');
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
		// Retrieve the form
		$complete = $this->input->post('complete');
		
		// Check if complete exists
		if($complete)
		{
			// Redirect to Admin CP
			redirect('admincp/dashboard');
		}
		
		// Check to see that the user has passed previous steps
		if( ! $this->session->userdata('step_5_passed'))
		{
			// Redirect the user back to step 5
			redirect('install/step5');
		}
			
		// Attempt Install
		$this->installer->attempt_install();
			
        // Destroy our session
        $this->session->sess_destroy();
		
        // Load installation completetion
        $this->load->view('install/complete');
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