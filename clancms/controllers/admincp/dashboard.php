<?php
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
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Dashboard Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Dashboard extends CI_Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{
		// Call the Controller constructor
		parent::__construct();
		
		// Check to see if user is an administrator
		if(!$this->user->is_administrator())
		{
			// User is not an administrator, redirect them
			redirect('account/login');
		}
		
		// Load the Alerts model
		$this->load->model('Alerts_model', 'alerts');
		
		// Check if update files exist
		$this->_check_update();
			
		// Check if installation files exist
		$this->_check_installation();
		
		// Check to see if the version of Clan CMS is up-to-date or needs to be updated, then alert the user if need be
		$this->_check_version();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP dashboard
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the forms
		$update_notepad = $this->input->post('update_notepad');
	
		// Check it update notepad has been posted
		if($update_notepad)
		{
			// Set form validation rules
			$this->form_validation->set_rules('notepad', 'Notepad', 'trim');
		
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'user_notes'	=> $this->input->post('notepad')
				);
			
				// Update the user in the database
				$this->users->update_user($this->session->userdata('user_id') , $data);
				
				// Alert the administrator
				$this->session->set_flashdata('message', 'Your notepad has been updated!');
				
				// Redirect the administrator
				redirect('admincp');
			}
		}
		
		// Retrieve the user
		$user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id')));
		
		// Retreive the alerts
		$alerts = $this->alerts->get_alerts(array('user_id' => $user->user_id));
		
		// Create a reference to alerts & user
		$this->data->alerts =& $alerts;
		$this->data->user =& $user;
		
		// Load the admin cp dashboard view
		$this->load->view(ADMINCP . 'dashboard', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Download
	 *
	 * Downloads a update
	 *
	 * @access	public
	 * @return	void
	 */
	function download()
	{
		// Check is administrator is super administrator
		if($this->session->userdata('user_id') != SUPERADMINISTRATOR)
		{
			// Administrator isn't a super administrator, redirect the administrator
			redirect(ADMINCP);
		}
		
		// Retrieve the update
		$update = $this->uri->segment(4, '');
		
		// Download the update
		copy('http://www.xcelgaming.com/download/ClanCMS-' . $update . '.zip', 'Update.zip');
		
		// Redirect the administrator
		redirect(ADMINCP . 'dashboard/update');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update
	 *
	 * Update the script
	 *
	 * @access	public
	 * @return	void
	 */
	function update()
	{
		// Check is administrator is super administrator
		if($this->session->userdata('user_id') != SUPERADMINISTRATOR OR !file_exists('Update.zip'))
		{
			// Administrator isn't a super administrator, redirect the administrator
			redirect(ADMINCP);
		}
		
		// Save the old version
		$this->session->set_userdata('CLANCMS_VERSION', CLANCMS_VERSION);
		
		// Load the file helper
		$this->load->helper('file');
		
		// Define the path to important files
		$important_files = array(
			'./clancms/config/config.php',
			'./clancms/config/database.php'
		);
		
		// Loop through the important files
		foreach($important_files as $important_file)
		{
			// Retrieve the files
			$file[$important_file] = read_file($important_file);
		}
		
		// Load the unzip library
		$this->load->library('unzip');
		
		// Change the permissions
		@chmod('Update.zip', 0777);
		
		// Unzip the update
		$this->unzip->extract('Update.zip');
		
		// Loop through the important files
		foreach($important_files as $important_file)
		{
			// Write the important files
			write_file($important_file, $file[$important_file]);
		}
		
		// Load the Installer library
		$this->load->library('installer');
		
		// Write the clancms file
		$this->installer->write_ClanCMS_file();
		
		// Load the update library
		$this->load->library('update');
		
		// Install the update
		$this->update->install();
		
		// Remove the old version
		$this->session->unset_userdata('CLANCMS_VERSION');
		
		// Delete the update package
		$this->update->self_destruct();
		unlink('Update.zip');
		
		// Redirect the administrator
		redirect(ADMINCP . 'dashboard/installation');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Update
	 *
	 * Checks to see if update files exist
	 *
	 * @access	private
	 * @return	void
	 */
	function _check_update()
	{
		// Check if files exist
		if(file_exists('Update.zip'))
		{
			// Check if alert already exists
			if(!$alert = $this->alerts->get_alert(array('alert_slug' => 'update')))
			{
				// Set up the data
				$data = array(
					'alert_title'	=> 'You have a pending manual update.',
					'alert_link'	=> 'admincp/dashboard/update',
					'alert_slug'	=> 'update',
					'user_id'		=> SUPERADMINISTRATOR
				);
			
				// Alert doesn't exist, insert the alert into the database
				$this->alerts->insert_alert($data);
			}
		}
		else
		{
			// Check if alert already exists
			if($alert = $this->alerts->get_alert(array('alert_slug' => 'update')))
			{
				// Alert doesn't exist, insert the alert into the database
				$this->alerts->delete_alert($alert->alert_id);
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Installation
	 *
	 * Destroys the installation files
	 *
	 * @access	public
	 * @return	void
	 */
	function installation()
	{
		// Load the Installer library
		$this->load->library('installer');
		
		// Call the Self Destruct on the Installer
		$this->installer->self_destruct();
		
		// Redirect the administrator
		redirect(ADMINCP);	
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Installation
	 *
	 * Checks to see if installation files exist
	 *
	 * @access	private
	 * @return	void
	 */
	function _check_installation()
	{
		// Check if files exist
		if(file_exists('./clancms/controllers/install.php') OR file_exists('./clancms/libraries/Installer.php'))
		{
			// Check if alert already exists
			if(!$alert = $this->alerts->get_alert(array('alert_slug' => 'installation')))
			{
				// Set up the data
				$data = array(
					'alert_title'	=> 'Installation Files Exist. Please Delete Them!',
					'alert_link'	=> 'admincp/dashboard/installation',
					'alert_slug'	=> 'installation',
					'user_id'		=> SUPERADMINISTRATOR
				);
			
				// Alert doesn't exist, insert the alert into the database
				$this->alerts->insert_alert($data);
			}
		}
		else
		{
			// Check if alert already exists
			if($alert = $this->alerts->get_alert(array('alert_slug' => 'installation')))
			{
				// Alert doesn't exist, insert the alert into the database
				$this->alerts->delete_alert($alert->alert_id);
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Version
	 *
	 * Checks to see if their is a later version out
	 *
	 * @access	private
	 * @return	void
	 */
	function _check_version()
	{
		// Load the file helper
		$this->load->helper('file');
		
		// Fetch the Latest Version
        if(!$latest_version = @file_get_contents('http://www.xcelgaming.com/download/latest_version'))
		{
			// Set up the data
			$data = array(
				'alert_title'	=> 'Could not check if a new version is available!',
				'alert_link'	=> 'http://www.xcelgaming.com/download',
				'alert_slug'	=> 'version',
				'user_id'		=> SUPERADMINISTRATOR
			);
			
			// Check if alert already exists
			if($alert = $this->alerts->get_alert(array('alert_slug' => 'version')))
			{
				// Alert already exists, update the alert in the database
				$this->alerts->update_alert($alert->alert_id, $data);
			}
			else
			{
				// Alert doesn't exist, insert the alert into the database
				$this->alerts->insert_alert($data);
			}
		}
		elseif((bool) version_compare(CLANCMS_VERSION, $latest_version, '<'))
		{
			// Set up the data
			$data = array(
				'alert_title'	=> 'New Version Available For Download: v' . $latest_version,
				'alert_link'	=> 'admincp/dashboard/download/' . $latest_version,
				'alert_slug'	=> 'version',
				'user_id'		=> SUPERADMINISTRATOR
			);
			
			// Check if alert already exists
			if($alert = $this->alerts->get_alert(array('alert_slug' => 'version')))
			{
				// Alert already exists, update the alert in the database
				$this->alerts->update_alert($alert->alert_id, $data);
			}
			else
			{
				// Alert doesn't exist, insert the alert into the database
				$this->alerts->insert_alert($data);
			}
		}
		elseif($latest_version == CLANCMS_VERSION)
		{
			// Retrieve the alert
			if($alert = $this->alerts->get_alert(array('alert_slug' => 'version')))
			{
				// Delete the alert from the database
				$this->alerts->delete_alert($alert->alert_id);
			}
		}
	}
}

/* End of file dashboard.php */
/* Location: ./clancms/controllers/admincp/dashboard.php */