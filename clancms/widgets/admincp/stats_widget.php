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
 * @since		Version 0.5.3
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Stats Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Stats_widget extends Widget {

	/**
	 * Constructor
	 *
	 */
	function Stats_widget()
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
	 * Display's the stats
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Articles model
		$this->CI->load->model('Articles_model', 'articles');
		
		// Retrieve the total number of published articles
		$this->data->total_articles_published = $this->CI->articles->count_articles(array('article_status' => 1));
		
		// Retrieve the total number of draft articles
		$this->data->total_articles_drafts = $this->CI->articles->count_articles(array('article_status' => 0));
		
		// Load the Matches model
		$this->CI->load->model('Matches_model', 'matches');
		
		// Retrieve the total number of matches
		$this->data->total_matches = $this->CI->matches->count_matches();
		
		// Load the Squads model
		$this->CI->load->model('Squads_model', 'squads');
		
		// Retrieve the total number of squads
		$this->data->total_squads = $this->CI->squads->count_squads();
		
		// Load the Sponsors model
		$this->CI->load->model('Sponsors_model', 'sponsors');
		
		// Retrieve the total number of sponsors
		$this->data->total_sponsors = $this->CI->sponsors->count_sponsors();
		
		// Retrieve the total number of users
		$this->data->total_users = $this->CI->users->count_users();
		
		// Retrieve the total number of default usergroups
		$this->data->total_usergroups_default = $this->CI->users->count_groups(array('group_default' => 1));
		
		// Retrieve the total number of custom usergroups
		$this->data->total_usergroups_custom = $this->CI->users->count_groups(array('group_default' => 0));
		
		// Load the Polls model
		$this->CI->load->model('Polls_model', 'polls');
		
		// Retrieve the total number of polls
		$this->data->total_polls = $this->CI->polls->count_polls();
		
		// Load the Pages model
		$this->CI->load->model('Pages_model', 'pages');
		
		// Retrieve the total number of pages
		$this->data->total_pages = $this->CI->pages->count_pages();
		
		// Load the admincp stats widget view
		$this->CI->load->view(ADMINCP . 'widgets/stats', $this->data);
	}
	
}
	
/* End of file stats_widget.php */
/* Location: ./clancms/widgets/admincp/stats_widget.php */