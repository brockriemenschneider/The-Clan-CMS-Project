<?php
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
 * @since		Version 0.5.6
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Opponents Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Opponents extends CI_Controller {
	
	/**
	 * Constructor
	 *
	 */	
	function __construct()
	{
		// Call the Controller constructor
		parent::__construct();
		
		// Check to see if user is an administrator
		if(!$this->user->is_administrator())
		{
			// User is not an administrator, redirect the user
			redirect('account/login');
		}
		
		// Check if the administrator has permission
		if(!$this->user->has_permission('opponents'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this opponent!');
			exit;
		}
		
		// Load the Matches model
		$this->load->model('Matches_model', 'matches');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Opponents
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve the page
		$page = $this->uri->segment(4, '');
	
		// Check if page exists
		if($page == '')
		{
			// Page doesn't exist, assign page
			$page = 1;
		}
	
		//Set up the variables
		$per_page = 10;
		$total_results = $this->matches->count_matches();
		$offset = ($page - 1) * $per_page;
		$pages->total_pages = 0;
		
		// Create the pages
		for($i = 1; $i < ($total_results / $per_page) + 1; $i++)
		{
			// Itterate pages
			$pages->total_pages++;
		}
				
		// Check if there are no results
		if($total_results == 0)
		{
			// Assign total pages
			$pages->total_pages = 1;
		}
		
		// Set up pages
		$pages->current_page = $page;
		$pages->pages_left = 9;
		$pages->first = (bool) ($pages->current_page > 5);
		$pages->previous = (bool) ($pages->current_page > '1');
		$pages->next = (bool) ($pages->current_page != $pages->total_pages);
		$pages->before = array();
		$pages->after = array();
		
		// Check if the current page is towards the end
		if(($pages->current_page + 5) < $pages->total_pages)
		{
			// Current page is not towards the end, assign start
			$start = $pages->current_page - 4;
		}
		else
		{
			// Current page is towards the end, assign start
			$start = $pages->current_page - $pages->pages_left + ($pages->total_pages - $pages->current_page);
		}
		
		// Assign end
		$end = $pages->current_page + 1;
		
		// Loop through pages before the current page
		for($page = $start; ($page < $pages->current_page); $page++)
		{
			// Check if the page is vaild
			if($page > 0)
			{
				// Page is valid, add it the pages before, increment pages left
				$pages->before = array_merge($pages->before, array($page));
				$pages->pages_left--;
			}
		}
		
		// Loop through pages after the current page
		for($page = $end; ($pages->pages_left > 0 && $page <= $pages->total_pages); $page++)
		{
			// Add the page to pages after, increment pages left
			$pages->after = array_merge($pages->after, array($page));
			$pages->pages_left--;
		}
		
		// Set up pages
		$pages->last = (bool) (($pages->total_pages - 5) > $pages->current_page);
		
		// Retrieve all opponents
		$opponents = $this->matches->get_opponents($per_page, $offset);
		
		// Check if opponents exist
		if($opponents)
		{
			// Opponensts exist, loop through each opponent
			foreach($opponents as $opponent)
			{
				// Count the opponent's total matches
				$opponent->total_matches = $this->matches->count_matches(array('opponent_id' => $opponent->opponent_id));
			}
		}
		
		// Create a reference to opponents & pages
		$this->data->opponents =& $opponents;
		$this->data->pages =& $pages;
		
		// Load the admincp opponents view
		$this->load->view(ADMINCP . 'opponents', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a opponent
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve the forms
		$add_opponent = $this->input->post('add_opponent');
		
		// Check it add opponent has been posted
		if($add_opponent)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('link', 'Link', 'trim|prep_url');
			$this->form_validation->set_rules('tag', 'Tag', 'trim');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'opponent_title'	=> $this->input->post('title'),
					'opponent_link'		=> $this->input->post('link'),
					'opponent_tag'		=> $this->input->post('tag')
				);
			
				// Insert the opponent into the database
				$this->matches->insert_opponent($data);
					
				// Retrieve the opponent id
				$opponent_id = $this->db->insert_id();
				
				// Set up our data
				$data = array (
					'opponent_slug'		=> $opponent_id . '-' . url_title($this->input->post('title'))
				);
				
				// Update the opponent into the database
				$this->matches->update_opponent($opponent_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The opponent was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'opponents/edit/' . $opponent_id);
			}
		}
		
		// Load the admincp opponents add view
		$this->load->view(ADMINCP . 'opponents_add');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a opponent
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'opponent_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the opponent
		if(!$opponent = $this->matches->get_opponent($data))
		{
			// Opponent doesn't exist, redirect the administrator
			redirect(ADMINCP . 'opponents');
		}
		
		// Retrieve the forms
		$update_opponent = $this->input->post('update_opponent');
		
		// Check it update opponent has been posted
		if($update_opponent)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('link', 'Link', 'trim|prep_url');
			$this->form_validation->set_rules('tag', 'tag', 'trim');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'opponent_title'	=> $this->input->post('title'),
					'opponent_slug'		=> $opponent->opponent_id . '-' . url_title($this->input->post('title')),
					'opponent_link'		=> $this->input->post('link'),
					'opponent_tag'		=> $this->input->post('tag')
				);
			
				// Update the opponent in the database
				$this->matches->update_opponent($opponent->opponent_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The opponent was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'opponents/edit/' . $opponent->opponent_id);
			}
		}
		
		// Create a reference to opponent
		$this->data->opponent =& $opponent;
		
		// Load the admincp opponents edit view
		$this->load->view(ADMINCP . 'opponents_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a opponent
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'opponent_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the opponent
		if(!$opponent = $this->matches->get_opponent($data))
		{
			// Opponent doesn't exist, redirect the administrator
			redirect(ADMINCP . 'opponents');
		}
				
		// Retrieve the matches
		if($matches = $this->matches->get_matches('', '', array('opponent_id' => $opponent->opponent_id)))
		{
			// Matches exist, loop through each match
			foreach($matches as $match)
			{
				// Set up the data
				$data = array(
					'opponent_id'	=>	0
				);
				
				// Update the match in the database
				$this->matches->update_match($match->match_id, $data);
			}
		}
		
		// Delete the opponent from the database
		$this->matches->delete_opponent($opponent->opponent_id);
		
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The opponent was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'opponents');
	}
	
}
/* End of file opponents.php */
/* Location: ./clancms/controllers/admincp/opponents.php */