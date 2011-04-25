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
		// Retrieve the forms
		$update_settings = $this->input->post('update_settings');
		
		// Check it update settings has been posted
		if($update_settings)
		{
			// Retrieve the settings
			$settings = $this->input->post('setting');
			
			// Check if settings exist
			if($settings)
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
						$this->settings->update_setting($setting->setting_id, array('setting_value' => $value));
					}
					
					// Alert the adminstrator
					$this->session->set_flashdata('message', 'The settings have been successfully updated!');
					
					// Redirect the adminstrator
					ci_redirect(ADMINCP . 'settings');
				}
			}
		}
		
		// Retrieve all the setting categories
		$categories = $this->settings->get_categories();
		
		// Check if categories exist
		if($categories)
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
		
		// Create a reference to the categories & category
		$this->data->categories =& $categories;
		$this->data->category =& $category;
		
		// Load the admincp settings view
		$this->load->view(ADMINCP . 'settings', $this->data);
	}
	
}

/* End of file settings.php */
/* Location: ./clancms/controllers/admincp/settings.php */