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
 * Clan CMS Alerts Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Alerts_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Alerts_widget()
	{
		// Call the Widget constructor
		parent::Widget();
		
		// Create a instance to CI
		$CI =& get_instance();
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
		
		// Load the admincp alerts widget view
		$this->CI->load->view(ADMINCP . 'widgets/alerts', $this->data);
	}
	
}
	
/* End of file alerts_widget.php */
/* Location: ./clancms/widgets/admincp/alerts_widget.php */