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
 * Clan CMS Admin CP Settings Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Settings extends CI_Controller {
	
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
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('settings'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Settings
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{	
		// Retrieve the category
		if($this->uri->segment(4, ''))
		{
			// Set up the data
			$search = array(
				'category_id'	=>	$this->uri->segment(4, '')
			);
			
			// Retrieve the searched category
			if(!$category_id = $this->settings->get_category($search)->category_id)
			{
				// Category doesn't exist, redirect the administrator
				redirect(ADMINCP . 'settings');
			}
		}
		else
		{
			// Assign search and category id
			$search = array();
			$category_id = 0;
		}
		
		// Retrieve the forms
		$edit_settings = $this->input->post('edit_settings');
		$update_settings = $this->input->post('update_settings');
		
		// Check if edit settings has been posted
		if($edit_settings)
		{
			// Set form validation rules
			$this->form_validation->set_rules('category', 'Category', 'trim|required');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Retrieve the category id
				if($category_id = $this->input->post('category'))
				{
					// Redirect the administrator
					redirect(ADMINCP . 'settings/index/' . $category_id);
				}
				else
				{
					// Redirect the administrator
					redirect(ADMINCP . 'settings');
				}
			}
		}
		
		// Check it update settings has been posted
		if($update_settings)
		{
			// Retrieve the settings
			if($settings = $this->input->post('setting'))
			{
				// Settings exist, loop through each setting
				foreach($settings as $setting_id => $value)
				{
					// Check if setting exists
					if($setting = $this->settings->get_setting(array('setting_id' => $setting_id)))
					{
						// Check if the setting is required
						if($setting->setting_rules)
						{
							// Set form validation rules
							$this->form_validation->set_rules('setting[' . $setting->setting_id . ']', $setting->setting_title, $setting->setting_rules);
						}
						
					}
				}
				
				// Form validation passed, so continue
				if (!$this->form_validation->run() == FALSE)
				{
					// Settings exist, loop through each setting
					foreach($settings as $setting_id => $value)
					{
						// Setting exists, update the setting in the database
						$this->settings->update_setting($setting_id, array('setting_value' => $value));
					}
					
					// Alert the adminstrator
					$this->session->set_flashdata('message', 'The settings have been successfully updated!');
					
					// Redirect the adminstrator
					redirect(ADMINCP . 'settings/index/' . $category_id);
				}
			}
		}
		
		// Retrieve all the setting categories
		$search_categories = $this->settings->get_categories();
		
		// Retrieve the searched for setting categories
		if($categories = $this->settings->get_categories($search))
		{
			// Categories exist, loop through each category
			foreach($categories as $category)
			{
				// Check if settings exist
				if($category->settings = $this->settings->get_settings(array('category_id' => $category->category_id)))
				{
					// Category settings exist, loop through each setting
					foreach($category->settings as $setting)
					{
						// Assign setting options
						$setting->options = array();
    	
						// Check if setting options exists
						if($setting->setting_options)
						{
							// Loop through the setting's options
							foreach(explode('|', $setting->setting_options) as $setting_option)
							{
								// Explode the options
								list($name, $value) = explode('=', $setting_option);
								
								// Assign the options to their values
								$setting->options[$name] = $value;
							}
						}
					}
				}
			}
		}
		
		// Create a reference to the category id, search categories & categories
		$this->data->category_id =& $category_id;
		$this->data->search_categories =& $search_categories;
		$this->data->categories =& $categories;
		
		// Load the admincp settings view
		$this->load->view(ADMINCP . 'settings', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Backup
	 *
	 * Display's the Admin CP Database Backup
	 *
	 * @access	public
	 * @return	void
	 */
	function backup()
	{
		// Retrieve the tables
		$tables = $this->db->list_tables();

		// Retrieve the forms
		$backup_database = $this->input->post('backup_database');
		
		// Check if backup database has been posted
		if($backup_database)
		{
			// Loop though the tables
			foreach($tables as $table)
			{
				// Set form validation rules
				$this->form_validation->set_rules('table[' . $table . ']', $table, 'trim|required');
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Load the database utility class
				$this->load->dbutil();
				
				// Retrieve the permissions
				$tables = $this->input->post('table');
				
				// Assign backup tables
				$backup_tables = array();
				
				// Loop through the tables
				foreach($tables as $table => $value)
				{
					// Check whether to include the table
					if($value)
					{
						// Add the table to backup tables
						array_push($backup_tables, $table);
					}
				}
				
				// Setup the config
				$config = array(
					'tables'	=> $backup_tables,
					'format'	=> 'txt',
					'filename'	=> 'ClanCMS-Backup-' .  date("m-d-Y") . '.sql'
				);
				
				// Retrieve the backup
				$backup =& $this->dbutil->backup($config); 
				
				// Load the download helper, force the download
				$this->load->helper('download');
				force_download($config['filename'], $backup);
			}
		}
		
		// Create a reference to the tablse
		$this->data->tables =& $tables;
		
		// Load the admincp settings backup view
		$this->load->view(ADMINCP . 'settings_backup', $this->data);
	}
}

/* End of file settings.php */
/* Location: ./clancms/controllers/admincp/settings.php */