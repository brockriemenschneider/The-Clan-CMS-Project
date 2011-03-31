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
 * Clan CMS Admin CP Polls Controller
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
		
		// Check to see if user is an administrator
		if(!$this->user->is_administrator())
		{
			// User is not an administrator, redirect the user
			redirect('account/login');
		}
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('polls'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the Polls model
		$this->load->model('Polls_model', 'polls');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Polls
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve all polls
		$polls = $this->polls->get_polls();
		
		// Check if polls exist
		if($polls)
		{
			// Polls exist, loop through each poll
			foreach($polls as $poll)
			{
				// Count the number of options the poll has
				$poll->total_options = $this->polls->count_options(array('poll_id' => $poll->poll_id));
				
				// Count the number of votes the poll has
				$poll->total_votes = $this->polls->count_votes(array('poll_id' => $poll->poll_id));
			}
		}
		
		// Create a reference to polls
		$this->data->polls =& $polls;
		
		// Load the admincp polls view
		$this->load->view(ADMINCP . 'polls', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a poll
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve the forms
		$add_poll = $this->input->post('add_poll');
		
		// Check it add poll has been posted
		if($add_poll)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('active', 'Active', 'trim|required');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'poll_title'		=> $this->input->post('title'),
					'poll_active'		=> $this->input->post('active')
				);
			
				// Check if poll is active
				if((bool) $this->input->post('active'))
				{
					// Poll is active, retrieve the current active poll
					$active_poll = $this->polls->get_poll(array('poll_active' => 1));
					
					// Update the current active poll to inactive
					$this->polls->update_poll($active_poll->poll_id, array('poll_active' => 0));
				}
				
				// Insert the poll into the database
				$this->polls->insert_poll($data);
					
				// Retrieve the poll id
				$poll_id = $this->db->insert_id();
					
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The poll was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'polls/edit/' . $poll_id);
			}
		}

		// Load the admincp polls add view
		$this->load->view(ADMINCP . 'polls_add');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a poll
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'poll_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the poll
		if(!$poll = $this->polls->get_poll($data))
		{
			// Poll doesn't exist, redirect the administrator
			redirect(ADMINCP . 'polls');
		}
		
		// Retrieve the forms
		$update_poll = $this->input->post('update_poll');
		$titles = $this->input->post('titles');
		
		// Check it update poll has been posted
		if($update_poll)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('active', 'Active', 'trim|required');
			
			// Check if titles exist
			if($titles)
			{
				// Loop through each option
				foreach($titles as $option_id => $title)
				{
					// Set form validation rules for each option
					$this->form_validation->set_rules('titles[' . $option_id . ']', 'Titles', 'trim');
				}
			}
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{
				// Set up the data
				$data = array (
					'poll_title'		=> $this->input->post('title'),
					'poll_active'		=> $this->input->post('active')
				);
				
				// Check if poll is active
				if((bool) $this->input->post('active'))
				{
					// Poll is active, retrieve the current active poll
					$active_poll = $this->polls->get_poll(array('poll_active' => 1));
					
					// Update the current active poll to inactive
					$this->polls->update_poll($active_poll->poll_id, array('poll_active' => 0));
				}
				
				// Update the poll in the database
				$this->polls->update_poll($poll->poll_id, $data);
				
				// Check if titles exist
				if($titles)
				{
					// Loop through each option
					foreach($titles as $option_id => $option_title)
					{
						// Set up the data
						$data = array(
							'option_title'		=> $titles[$option_id]
						);
						
						// Update the poll option in the database
						$this->polls->update_option($option_id, $data);				
					}
				}
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The poll was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'polls/edit/' . $poll->poll_id);
			}
		}
		
		// Check if options exist
		if($options = $this->polls->get_options(array('poll_id' => $poll->poll_id)))
		{
			// Options exist, loop through each option
			foreach($options as $option)
			{
				// Count the total number of votes for this option
				$option->total_votes = $this->polls->count_votes(array('option_id' => $option->option_id));
			}
		}
		
		// Create a reference to poll & options
		$this->data->poll =& $poll;
		$this->data->options =& $options;
		
		// Load the admincp polls edit view
		$this->load->view(ADMINCP . 'polls_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a poll
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'poll_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the poll
		if(!$poll = $this->polls->get_poll($data))
		{
			// Poll doesn't exist, redirect the administrator
			redirect(ADMINCP . 'polls');
		}
		
		// Check if options exist
		if($options = $this->polls->get_options(array('poll_id' => $poll->poll_id)))
		{
			// Options exist, loop through each option
			foreach($options as $option)
			{
				// Check if votes exist
				if($votes = $this->polls->get_votes(array('option_id' => $option->option_id)))
				{
					// Votes exist, loop through each vote
					foreach($votes as $vote)
					{
						// Delete the vote from the database
						$this->polls->delete_vote($vote->vote_id);
					}
				}
				
				// Delete the option from the database
				$this->polls->delete_option($option->option_id);
			}
		}
		
		// Delete the poll from the database
		$this->polls->delete_poll($poll->poll_id);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The poll was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'polls');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Order Options
	 *
	 * Updates the order of the options
	 *
	 * @access	public
	 * @return	void
	 */
	function order_options()
	{	
		// Retrieve the options
		$options = $this->input->post('option');

		// Loop through each option
		foreach($options as $option_priority => $option_id)
		{
			// Set up the data
			$data = array(
				'option_priority' =>	$option_priority 
			);
	
			// Update the option's order in the database
			$this->polls->update_option($option_id, $data);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Option
	 *
	 * Deletes a option from a poll
	 *
	 * @access	public
	 * @return	void
	 */
	function delete_option()
	{	
		// Retrieve the option id
		$option_id = $this->uri->segment(4, '');
		
		// Retrieve the option
		if(!$option = $this->polls->get_option(array('option_id' => $option_id)))
		{
			// Option doesn't exist, redirect the administrator
			redirect(ADMINCP . 'polls');
		}
		
		// Retrieve the poll
		if(!$poll = $this->polls->get_poll(array('poll_id' => $option->poll_id)))
		{
			// Poll doesn't exist, redirect the administrator
			redirect(ADMINCP . 'polls');
		}
		
		// Retrieve the votes
		$votes = $this->polls->get_votes(array('option_id' => $option->option_id));
		
		// Check if votes exist
		if($votes)
		{
			// Votes exist, loop through each vote
			foreach($votes as $vote)
			{
				// Delete the vote from the database
				$this->polls->delete_vote($vote->vote_id);
			}
		}
		
		// Delete the poll option from the database
		$this->polls->delete_option($option_id);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The option was successfully deleted!');
		
		// Redirect the adminstrator
		redirect(ADMINCP . 'polls/edit/' . $poll->poll_id);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Votes
	 *
	 * Deletes votes from a poll option
	 *
	 * @access	public
	 * @return	void
	 */
	function delete_votes()
	{	
		// Retrieve the option id
		$option_id = $this->uri->segment(4, '');
		
		// Retrieve the option
		if(!$option = $this->polls->get_option(array('option_id' => $option_id)))
		{
			// Option doesn't exist, redirect the administrator
			redirect(ADMINCP . 'polls');
		}
		
		// Retrieve the poll
		if(!$poll = $this->polls->get_poll(array('poll_id' => $option->poll_id)))
		{
			// Poll doesn't exist, redirect the administrator
			redirect(ADMINCP . 'polls');
		}
		
		// Retrieve the votes
		$votes = $this->polls->get_votes(array('option_id' => $option->option_id));
		
		// Check if votes exist
		if($votes)
		{
			// Votes exist, loop through each vote
			foreach($votes as $vote)
			{
				// Delete the vote from the database
				$this->polls->delete_vote($vote->vote_id);
			}
		}
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The votes were successfully deleted!');
		
		// Redirect the adminstrator
		redirect(ADMINCP . 'polls/edit/' . $poll->poll_id);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add Option
	 *
	 * Adds a option to a squad
	 *
	 * @access	public
	 * @return	void
	 */
	function add_option()
	{	
		// Set form validation rules
		$this->form_validation->set_rules('poll_id', 'Poll ID', 'trim|required');
		$this->form_validation->set_rules('option', 'Option', 'trim|required');
			
		// Retrieve the poll
		if(!$poll = $this->polls->get_poll(array('poll_id' => $this->input->post('poll_id'))))
		{
			// Poll doesn't exist, redirect the administrator
			redirect(ADMINCP . 'polls');
		}
		
		// Form validation passed, so continue
		if (!$this->form_validation->run() == FALSE)
		{
			// Set up the data
			$data = array (
				'poll_id'			=> $poll->poll_id,
				'option_title'		=> $this->input->post('option')
			);
			
			// Insert the poll option into the database
			$this->polls->insert_option($data);
			
			// Retrieve the option id
			$option_id = $this->db->insert_id();
			
			// Set up the data
			$data = array(
				'option_priority'	=> $option_id
			);
					
			// Update the poll option in the database
			$this->polls->update_option($option_id, $data);				
			
			// Alert the adminstrator
			$this->session->set_flashdata('message', 'The option was successfully added!');
		}
		else
		{
			// Alert the adminstrator
			$this->session->set_flashdata('message', 'The option field is required!');
		}
			
		// Redirect the adminstrator
		redirect(ADMINCP . 'polls/edit/' . $poll->poll_id);
	}
	
}
/* End of file polls.php */
/* Location: ./clancms/controllers/admincp/polls.php */