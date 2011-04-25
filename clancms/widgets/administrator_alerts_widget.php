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
 * @since		Version 0.6.0
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Administrator Alerts Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Administrator_alerts_widget extends Widget {

	// Widget information
	public $title = 'Administrator Alerts';
	public $description = "Display's alerts that are assigned to the administrator and allows them to resolve them.";
	public $author = 'Xcel Gaming';
	public $link = 'http://www.xcelgaming.com';
	public $version = '1.0.0';
	
	// Widget settings
	public $settings = array();
	
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Widget constructor
		parent::__construct();
		
		// Create a instance to CI
		$this->CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the alerts
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Alerts model
		$this->CI->load->model('Alerts_model', 'alerts');
		
		// Retrieve the alerts
		$alerts = $this->CI->alerts->get_alerts(array('user_id' => $this->CI->session->userdata('user_id')));
		
		// Create a reference to alerts
		$this->data->alerts =& $alerts;
		
		// Load the administrator alerts widget view
		$this->CI->load->view('widgets/administrator_alerts', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * Uninstall's the widget
	 *
	 * @access	public
	 * @return	void
	 */
	function uninstall()
	{
		// Assign files
		$files = array(
			APPPATH . 'views/widgets/administrator_alerts.php'
		);
		
		// Loop through the files
		foreach($files as $file)
		{
			// Check if the file exists
			if(file_exists($file))
			{
				// Delete the file
				unlink($file);
			}
		}
		
		// Delete the widget
		unlink(__FILE__);
	}
	
}
	
/* End of file administrator_alerts_widget.php */
/* Location: ./clancms/widgets/administrator_alerts_widget.php */