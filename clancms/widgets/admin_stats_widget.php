<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Clan CMS
 *
 * An open source application for gaming clans
 *
 * @package		Clan CMS
 * @author		Xcel Gaming Development Team
 * @copyright		Copyright (c) 2010 - 2011, Xcel Gaming, Inc.
 * @license		http://www.xcelgaming.com/about/license/
 * @link			http://www.xcelgaming.com
 * @since			Version 0.6.2
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin Site Stats Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category		Widgets
 * @author		Xcel Gaming Development Team
 * @link			http://www.xcelgaming.com
 */
class Admin_stats_widget extends Widget {

	// Widget information
	public $title = 'Admin Site Stats';
	public $description = "Administrator version of site stats.";
	public $author = 'Xcel Gaming';
	public $link = 'http://www.xcelgaming.com';
	public $version = '1.3.0';
	public $requires = '0.6.2';
	public $compatible = '0.6.2';
	
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		// Call the Widget constructor
		parent::__construct();
		
		// Create a instance to CI
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the stats for admin
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
		
		// Retrieve the total number of opponents
		$this->data->total_opponents = $this->CI->matches->count_opponents();
		
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
		
		// Load the Gallery model
		$this->CI->load->model('Gallery_model', 'gallery');
		
		// Retrieve the total number of images and videos
		$this->data->total_images = $this->CI->gallery->count_images();
		$this->data->total_videos = $this->CI->gallery->count_videos();
		
		// Load the Shouts model
		$this->CI->load->model('Shouts_model', 'shouts');
		
		// Retrieve total number of shouts
		$this->data->total_shouts = $this->CI->shouts->count_shouts();
		
		// Load the Widgets model
		$this->CI->load->model('Widgets_model', 'widgets');
		
		// Retrieve the total number of widgets
		$widgets = $this->CI->widgets->scan_widgets();
		
		// Assign widget total
		$widget_total = 0;
		
		// Loop through the widgets
		foreach($widgets as $widget)
		{
			// Itterate widget_total
			$widget_total++;
		}
		
		// Assign total widgets
		$this->data->total_widgets = $widget_total;
		
		// Assign the widget info
		$widget->title = 'Admin Site Stats';
		$widget->content = $this->CI->load->view('widgets/admin_stats', $this->data, TRUE);
		$widget->tabs = array();
			
		// Load the widget view
		$this->CI->load->view(WIDGET . 'widget', $widget);
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
			APPPATH . 'views/widgets/admin_stats.php'
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
	
/* End of file admin_stats_widget.php */
/* Location: ./clancms/widgets/admin_stats_widget.php */