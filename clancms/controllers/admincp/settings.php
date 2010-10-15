<?php
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
class Settings extends Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function Settings()
	{
		// Call the Controller constructor
		parent::Controller();
	
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
			$error =& load_class('Exceptions');
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
						// Setting exists, update the setting in the database
						$this->settings->update_setting($setting->setting_id, array('setting_value' => $value));
					}
				}
			}
			
			// Alert the adminstrator
			$this->session->set_flashdata('message', 'The settings have been successfully updated!');
				
			// Redirect the adminstrator
			redirect(ADMINCP . 'settings');
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
				if($settings = $this->settings->get_settings(array('category_id' => $category->category_id)))
				{
					// Settings exist, assign category settings
					$category->settings = $settings;
				}
				else
				{
					// Settings doesn't exist, assign category settings
					$category->settings = '';
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