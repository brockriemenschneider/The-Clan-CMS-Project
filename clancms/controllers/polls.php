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
 * @since		Version 0.5.5
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Polls Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Polls extends Controller {

	/**
	 * Constructor
	 *
	 */	
	function Polls()
	{
		// Call the Controller constructor
		parent::Controller();
		
		// Load the Polls model
		$this->load->model('Polls_model', 'polls');
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
		// Retrieve polls
		$polls = $this->polls->get_polls();
		
		// Retrieve our forms
		$add_vote = $this->input->post('add_vote');
		
		// Check it add vote has been posted and check if the user is logged in
		if($add_vote && $this->user->logged_in())
		{
			// Set form validation rules
			$this->form_validation->set_rules('option', 'Option', 'trim|required');
			
			// Retrieve the option
			$option = $this->polls->get_option(array('option_id' => $this->input->post('option')));
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'poll_id'		=> $option->poll_id,
					'option_id'		=> $option->option_id,
					'user_id'		=> $this->session->userdata('user_id')
				);
			
				// Insert the comment into the database
				$this->polls->insert_vote($data);
				
				// Alert the user
				$this->session->set_flashdata('message', 'Your vote has been submitted!');
				
				// Redirect the user
				redirect('polls');
			}
		}
		
		// Check if polls exist
		if($polls)
		{
			// Polls exist, loop through each poll
			foreach($polls as $poll)
			{
				// Count the total number of votes for this poll
				$poll->total_votes = $this->polls->count_votes(array('poll_id' => $poll->poll_id));
		
				// Retrieve the poll options
				$poll->options = $this->polls->get_options(array('poll_id' => $poll->poll_id));
		
				// Check if options exist
				if($poll->options)
				{
					// Options exist, loop through each option
					foreach($poll->options as $option)
					{
						// Count the number of total votes for this option
						$option->total_votes = $this->polls->count_votes(array('option_id' => $option->option_id));
				
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
				$poll->voted = $this->polls->get_vote(array('poll_id' => $poll->poll_id, 'user_id' => $this->session->userdata('user_id')));
			}
		}
		
		// Create a reference to polls & poll
		$this->data->polls =& $polls;
		$this->data->poll =& $poll;
		
		// Load the polls view
		$this->load->view(THEME . 'polls', $this->data);
	}
	
}

/* End of file polls.php */
/* Location: ./clancms/controllers/polls.php */