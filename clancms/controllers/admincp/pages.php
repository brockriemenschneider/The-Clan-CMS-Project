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
 * @since		Version 0.5.4
 */

// ------------------------------------------------------------------------

/**
 * Clan CMS Admin CP Pages Controller
 *
 * @package		Clan CMS
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Xcel Gaming Development Team
 * @link		http://www.xcelgaming.com
 */
class Pages extends CI_Controller {
	
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
		if(!$this->user->has_permission('pages'))
		{
			// Administrator doesn't have permission, show error & exit
			$error =& load_class('Exceptions', 'core');
			echo $error->show_error('Access Denied!', 'You do not have permission to view this page!');
			exit;
		}
		
		// Load the Pages model
		$this->load->model('Pages_model', 'pages');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * Display's the Admin CP Pages
	 *
	 * @access	public
	 * @return	void
	 */
	function index()
	{
		// Retrieve all pages
		$pages = $this->pages->get_pages();
		
		// Create a reference to pages
		$this->data->pages =& $pages;
		
		// Load the admincp pages view
		$this->load->view(ADMINCP . 'pages', $this->data);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Add
	 *
	 * Add's a page
	 *
	 * @access	public
	 * @return	void
	 */
	function add()
	{
		// Retrieve the forms
		$add_page = $this->input->post('add_page');
		
		// Check it add page has been posted
		if($add_page)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('slug', 'Slug', 'trim|required|alpha_dash|callback__check_slug');
			$this->form_validation->set_rules('content', 'Content', 'trim');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'page_title'		=> $this->input->post('title'),
					'page_slug'			=> $this->input->post('slug'),
					'page_content'		=> $this->input->post('content'),
					'page_priority'		=> $this->input->post('priority')
				);
			
				// Insert the page into the database
				$this->pages->insert_page($data);
					
				// Retrieve the page id
				$page_id = $this->db->insert_id();
					
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The page was successfully added!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'pages/edit/' . $page_id);
			}
		}
		
		// Load the admincp pages add view
		$this->load->view(ADMINCP . 'pages_add');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * Edit's a page
	 *
	 * @access	public
	 * @return	void
	 */
	function edit()
	{
		// Set up the data
		$data = array(
			'page_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the page
		if(!$page = $this->pages->get_page($data))
		{
			// Page doesn't exist, redirect the administrator
			redirect(ADMINCP . 'pages');
		}
		
		// Retrieve the forms
		$update_page = $this->input->post('update_page');
		
		// Check it update page has been posted
		if($update_page)
		{
			// Set form validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			
			// Check if page slug changed
			if($page->page_slug != $this->input->post('slug'))
			{
				// Page slug changed, set form validation rules
				$this->form_validation->set_rules('slug', 'Slug', 'trim|required|alpha_dash|callback__check_slug');
			}
			
			// Set form validation rules
			$this->form_validation->set_rules('content', 'Content', 'trim');
			$this->form_validation->set_rules('priority', 'Priority', 'trim|required|integer');
			
			// Form validation passed, so continue
			if (!$this->form_validation->run() == FALSE)
			{	
				// Set up the data
				$data = array (
					'page_title'		=> $this->input->post('title'),
					'page_slug'			=> $this->input->post('slug'),
					'page_content'		=> $this->input->post('content'),
					'page_priority'		=> $this->input->post('priority')
				);
			
				// Update the page in the database
				$this->pages->update_page($page->page_id, $data);
				
				// Alert the adminstrator
				$this->session->set_flashdata('message', 'The page was successfully updated!');
				
				// Redirect the adminstrator
				redirect(ADMINCP . 'pages/edit/' . $page->page_id);
			}
		}
		
		// Create a reference to page
		$this->data->page =& $page;
		
		// Load the admincp pages edit view
		$this->load->view(ADMINCP . 'pages_edit', $this->data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * Delete's a page
	 *
	 * @access	public
	 * @return	void
	 */
	function delete()
	{
		// Set up the data
		$data = array(
			'page_id'	=>	$this->uri->segment(4)
		);
		
		// Retrieve the page
		if(!$page = $this->pages->get_page($data))
		{
			// Page doesn't exist, redirect the administrator
			redirect(ADMINCP . 'pages');
		}
				
		// Delete the page from the database
		$this->pages->delete_page($page->page_id);
				
		// Alert the adminstrator
		$this->session->set_flashdata('message', 'The page was successfully deleted!');
				
		// Redirect the adminstrator
		redirect(ADMINCP . 'pages');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Slug
	 *
	 * Check's to see if a slug is unique
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	function _check_slug($slug = '')
	{
		// Set up the data
		$data = array(
			'page_slug'		=> $slug
		);
		
		// Retrieve the page
		if(!$page = $this->pages->get_page($data))
		{
			// Page doesn't exist, return TRUE
			return TRUE;
		}
		else
		{
			// Page exists, alert the user & return FALSE
			$this->form_validation->set_message('_check_slug', 'That page slug is already taken.');
			return FALSE;
		}
	}
}

/* End of file pages.php */
/* Location: ./clancms/controllers/admincp/pages.php */