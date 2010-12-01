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
 * @since		Version 0.5.5
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
	
	/**
	 * Constructor
	 *
	 */
	function Polls_widget()
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
	 * Display's the polls
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Load the Polls model
		$this->CI->load->model('Polls_model', 'polls');
		
		// Retrieve the active poll
		if($poll = $this->CI->polls->get_poll(array('poll_active' => 1)))
		{
			// Count the total number of votes for this poll
			$poll->total_votes = $this->CI->polls->count_votes(array('poll_id' => $poll->poll_id));
		
			// Retrieve the poll options
			$poll->options = $this->CI->polls->get_options(array('poll_id' => $poll->poll_id));
		
			// Check if options exist
			if($poll->options)
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
		
		// Load the polls widget view
		$this->CI->load->view(THEME . 'widgets/polls', $this->data);
	}
}
	
/* End of file polls_widget.php */
/* Location: ./clancms/widgets/polls_widget.php */