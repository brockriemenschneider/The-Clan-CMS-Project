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
 * Clan CMS Polls Widget
 *
 * @package		Clan CMS
 * @subpackage	Widgets
 * @category	Widgets
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Polls_widget extends Widget {
	
	// Widget information
	public $title = 'Polls';
	public $description = "Display's polls that registered users can vote on.";
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
		$CI =& get_instance();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the polls
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Polls model
		$this->CI->load->model('Polls_model', 'polls');
	
		// Check if the poll exists
		if($poll = $this->CI->polls->get_poll(array('poll_active' => 1)))
		{
			// Count the total number of votes for this poll
			$poll->total_votes = $this->CI->polls->count_votes(array('poll_id' => $poll->poll_id));
		
			// Retrieve the poll options
			if($poll->options = $this->CI->polls->get_options(array('poll_id' => $poll->poll_id)))
			{
				// Options exist, loop through each option
				foreach($poll->options as $option)
				{
					// Count the number of total votes for this option
					$option->total_votes = $this->CI->polls->count_votes(array('option_id' => $option->option_id));
				
					// Check if the total votes equals 0
					if($poll->total_votes == 0)
					{
						// Determine the percent votes for each option
						$option->percent = round(($option->total_votes / 1) * 100);
					}
					else
					{
						// Determine the percent votes for each option
						$option->percent = round(($option->total_votes / $poll->total_votes) * 100);
					}
				}
			}
	
			// Check if the user has already voted
			$poll->voted = $this->CI->polls->get_vote(array('poll_id' => $poll->poll_id, 'user_id' => $this->CI->session->userdata('user_id')));
		}
		
		// Create a reference to poll
		$this->data->poll =& $poll;
	
		// Assign the widget info
		$widget->title = 'Poll';
		$widget->content = $this->CI->load->view('widgets/polls', $this->data, TRUE);
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
			APPPATH . 'views/widgets/polls.php'
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
	
/* End of file polls_widget.php */
/* Location: ./clancms/widgets/polls_widget.php */