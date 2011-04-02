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
 * @since		Version 0.5.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Model
 *
 * @package		Clan CMS
 * @subpackage	Models
 * @category	Models
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class ClanCMS extends Model {

	/**
	 * Constructor
	 *
	 */
	function ClanCMS()
	{
		// Call the Model constructor
		parent::Model();
		
		// Create an instance to CI
		$CI =& get_instance();
		
		// Load the settings, users & session models
		$CI->load->model('Settings_model', 'settings');
		$CI->load->model('Users_model', 'users');
		$CI->load->model('Session_model', 'user');
		
		// Define Install
		define('INSTALL', TRUE);
		
		// Check if we are installing
		if(!INSTALL)
		{
			// Define frequently used settings
			define('CLAN_NAME', $this->get_setting('clan_name'));
			define('THEME', 'themes/' . $this->get_setting('theme') . '/');
			define('THEME_URL', base_url() . 'clancms/views/themes/' . $this->get_setting('theme') . '/');
			define('ADMINCP', 'admincp/');
			define('ADMINCP_URL', base_url() . 'clancms/views/' . ADMINCP);
			define('IMAGES', base_url() . 'clancms/views/images/');
			define('UPLOAD', 'clancms/views/images/');
			define('SUPERADMINISTRATOR', '__SUPERADMINISTRATOR__');
		
			// Check if the user is remembered
			$CI->user->is_remembered();
		
			// Set the current URL the user was browsing
			$this->session->set_userdata('previous', $this->session->userdata('current'));
		
			// Set the current URL the user is browsing
			$this->session->set_userdata('current', uri_string());
		
			// Check if the user is logged in
			if(!$CI->user->logged_in())
			{
				// User isn't logged in, set session data
				$this->session->set_userdata('user_id', '');
				$this->session->set_userdata('username', '');
				$this->session->set_userdata('password', '');
			}
			else
			{
				// Check if the user is banned
				if($CI->user->is_banned() && $this->uri->segment(2, '') != "banned")
				{
					// User is banned, redirect to banned
					redirect('dashboard/banned');
				}
			}
		}
		else
		{
			// Prevent an infinite loop
			if($this->uri->segment(1, '') == '')
			{
				// Redirect to the install guide
				redirect('install/index');
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get Setting
	 *
	 * Retrieves a setting from the database
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function get_setting($setting_slug = '')
	{
		// Create an instance to CI
		$this->CI =& get_instance();
	
		// Check if setting exists
		if($setting = $this->CI->settings->get_setting(array('setting_slug' => $setting_slug)))
		{
			// Setting exists, return the setting value
			return $setting->setting_value;
		}
		else
		{
			// Setting doesn't exist, return FALSE
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Timezone
	 *
	 * Converts a timestamp to either the default timezone or the user's preference
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function timezone($timestamp = '')
	{
		// Convert the timestamp to unix
		$unix = mysql_to_unix($timestamp);
		
		// Check if the user is logged in
		if($this->user->logged_in())
		{
			// User is logged in, retrieve the user
			if($user = $this->users->get_user(array('user_id' => $this->session->userdata('user_id'))))
			{
				// User exists, assign timezone
				$timezone = $user->user_timezone;
				
				// Check if user daylight savings is 2
				if($user->user_daylight_savings == 2)
				{
					// User daylight savings is 2, assign daylight savings
					$daylight_savings = $this->get_setting('daylight_savings');
				}
				else
				{
					// User daylight savings isn't 2, assign daylight savings
					$daylight_savings = $user->user_daylight_savings;
				}
			}
			else
			{
				// User doesn't exist, assign timezone & daylight savings
				$timezone = $this->get_setting('default_timezone');
				$daylight_savings = $this->get_setting('daylight_savings');
			}
		}
		else
		{
			// User is not logged, assign timezone & daylight savings
			$timezone = $this->get_setting('default_timezone');
			$daylight_savings = $this->get_setting('daylight_savings');
		}
		
		// Return the converted timestamp
		return gmt_to_local($unix, $timezone, $daylight_savings);
	}
	
}

/* End of file clancms.php */
/* Location: ./clancms/models/clancms.php */